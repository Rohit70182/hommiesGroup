<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use App\Models\User;
use Modules\Chat\Entities\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Services\Entities\CustomReq;

class ChatsController extends Controller
{

    /**
     *
     * @OA\Post(
     *      path="/chats/send-message",
     *      operationId="sendMessage",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"to_id"},
     *              @OA\Property(property="to_id", type="string", format="number", example="1"),
     *              @OA\Property(property="message", type="string", format="text", example="message here"),
     *              @OA\Property(description="Add files to upload", property="image",type="array", @OA\Items(type="file",format="binary")),
     *           ),
     *       ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Message sent successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Authentication error"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Not found error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function sendMessage(Request $request)
    {
        $validator = validator($request->all(), [
            'to_id' => 'required|numeric',
            'message' => 'required_without:image',
            'image' => 'required_without:message|mimes:jpeg,jpg,png|nullable'
        ]);
        
        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        if(!empty($request->message) && empty($request->image)) {
            $messageType = Chat::ONLY_MESSAGE;
        } else if(empty($request->message) && !empty($request->image)) {
            $messageType = Chat::ONLY_IMAGE;
        } else if(!empty($request->message) && !empty($request->image)) {
            $messageType = Chat::IMAGE_AND_MESSAGE;
        }
        
       
        
        if(!empty($request->image)) {
            $validator = validator($request->all(), [
                'image' => 'mimes:jpeg,png,jpg|max:2048'
            ]);
            if ($validator->fails()) {
                return response([
                    "status" => 422,
                    'message' => $validator->errors()
                ]);
            }
        }
        $chat = new Chat();
        $chat->from_id =2;
        $chat->to_id = $request->to_id;
        $chat->message = $request->message;
        $chat->readers =2 . ',' . $chat->to_id;
        $chat->type_id = Chat::USER_MESSAGE;
        $chat->message_type = $messageType;
        
        if ($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $chat->file = $filename;
        }

        if ($chat->save()) {
            return response([
                'message' => 'Success, Message sent successfully',
                'detail' => $chat
            ], 200);
        } else {
            return response([
                'message' => 'Unexpected error occurred'
            ], 404);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/chats/load-chat",
     *      operationId="loadChat",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="user_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Details fetched"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Authentication error"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Not found error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function loadChat(Request $request)
    {
        $chat = Chat::query();
        
        $validator = validator($request->all(), [
            'user_id' => 'required|integer'
        ]);
        
        if ($validator->fails()) {

            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        if (! empty($request->user_id))

            $chat = $chat->where('from_id', $request->user_id)
                ->orwhere('to_id', $request->user_id)
                ->with('fromId','toId')
                ->orderBy('id','DESC')
                ->get();
        if ($chat) {
            return response([
                'list' => $chat,
                'message' => 'chats list'
            ], 200);
        } else {
            return response([
                'message' => 'Not found'
            ], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/chats/chat-list",
     *      operationId="chatList",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *      
     *     @OA\Parameter(
     *     name="user_id",
     *     in="query",
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Chat list fetched"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Authentication error"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="string", example="Not found error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function chatList(Request $request)
    {
        $chats = Chat::query();

        $chats = $chats->where('from_id', Auth::id())
        ->orWhere('to_id', Auth::id())->get();
         
        $ids = [];
        foreach ($chats as $chat) {
        
            if ($chat->from_id != Auth::id()  ) {
                array_push($ids, $chat->from_id);
            }
            if ($chat->to_id != Auth::id()  ) {
                array_push($ids, $chat->to_id);
            }
        }
        $ids = array_unique($ids);
        
        foreach ($ids as $user)
        {
            $users[] = User::where('id',$user)->get();
        }
        
        if ($chat) 
        {
            return response([
                'list' => $users,
                'message' => 'chats list'
            ], 200);
        } 
        else 
        {
            return response([
                'message' => 'Not found'
            ], 400);
        }
    }
    
    /**
     *
     * @OA\Get(
     *      path="/chats/users-list",
     *      operationId="usersList",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Chat list fetched"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Authentication error"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="string", example="Not found error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function usersList(Request $request) {
        $userlist = User::all();
        
        
        if(!empty($userlist)) {
            return response([
                'list' => $userlist,
                'message' => 'chats list'
            ], 200);
        } else {
            return response([
                'message' => 'Something went wrong'
            ], 400);
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/chats/delete-message",
     *      operationId="deleteMessage",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="message_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Message deleted successfully"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Not Found Error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function deleteMessage(Request $request)
    { 
        $message = Chat::query();
        $messageId = $request->message_id;
        
        if(!empty($messageId)) 
        {
          $getMessage = $message->where('id', $messageId)->first();
            
          if(!empty($getMessage)) 
            {
                $getMessage->delete();
                return response([
                    'message' => 'Message deleted successfully',
                    'list' => $messageId
                ], 200);
            } 
            else 
            {
                return response([
                    'message' => 'Message id does not exist'
                ], 404);
            }
        } 
        else 
        {
            return response([
                'message' => 'Empty message id'
            ], 404);
        }

    }
    
    

    /**
     *
     * @OA\Get(
     *      path="/chats/delete-chat",
     *      operationId="deleteChat",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="user_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Details fetched"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Authentication error"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Not found error"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function deleteChat(Request $request)
    {
        $chat = Chat::query();
        $validator = validator($request->all(), [
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) 
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        if (! empty($request->user_id))
        {
            $chat = $chat->where('from_id', $request->user_id)
                         ->orwhere('to_id', $request->user_id)
                         ->get();
           foreach ($chat as $chats) 
           {
               $chats->delete();
           }
                return response([
                    'list' => $chat,
                    'message' => 'Chat deleted successfully'
                ], 200);
        }
        else 
         {
             return response([
              'message' => 'Not found'
             ], 400);
         }
    }
}