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
     *      summary="chat with service provider and user",
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"to_id","property_id"},
     *              @OA\Property(property="to_id", type="string", format="number", example="1"),
     *              @OA\Property(property="property_id", type="string", format="number", example="1"),
     *              @OA\Property(property="message", type="string", format="text", example="message here"),
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
        $fromId = auth()->id();
        $validator = validator($request->all(), [
            'to_id' => 'required|numeric',
            'property_id' => 'required|numeric',
            'message' => 'required_without:image',
            // 'image' => 'required_without:message|mimes:jpeg,jpg,png|nullable'
        ]);

        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }

        if (!empty($request->message) && empty($request->image)) {
            $messageType = Chat::ONLY_MESSAGE;
        } else if (empty($request->message) && !empty($request->image)) {
            $messageType = Chat::ONLY_IMAGE;
        } else if (!empty($request->message) && !empty($request->image)) {
            $messageType = Chat::IMAGE_AND_MESSAGE;
        }

        if (!empty($request->image)) {
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
        $chat->from_id = $fromId;
        $chat->to_id = $request->to_id;
        $chat->message = $request->message;
        $chat->readers = $fromId . ',' . $chat->to_id;
        $chat->type_id = Chat::USER_MESSAGE;
        $chat->is_read = Chat::READ_NO;
        $chat->property_id = $request->property_id;
        $chat->message_type = $messageType;

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $chat->file = $filename;
        }

        if ($chat->save()) {
            $chat->load('fromId', 'toId');
            return response([
                'message' => 'Success, Message sent successfully',
                'chat' => $chat
            ], 200);
        } else {
            return response([
                'message' => 'Unexpected error occurred'
            ], 404);
        }
    }

    /**
     * @OA\Get(
     *      path="/chats/load-chat",
     *      operationId="loadChat",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="Load chat messages with read status update",
     *
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         ),
     *     ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Page number for pagination (default is 1)",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Chats loaded successfully"),
     *        @OA\Property(property="list", type="array", @OA\Items())
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Validation Error",
     *    @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Validation error")
     *    )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="No chats found")
     *    )
     * )
     * )
     */
    public function loadChat(Request $request)
    {
        $authUserId = Auth::id();
        $validator = validator($request->all(), [
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ], 422);
        }

        $userId = $request->input('user_id');
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 15);
        $chat = Chat::where(function ($query) use ($userId, $authUserId) {
            $query->where('from_id', $userId)->where('to_id', $authUserId);
        })
            ->orWhere(function ($query) use ($userId, $authUserId) {
                $query->where('from_id', $authUserId)->where('to_id', $userId);
            })
            ->with('fromId', 'toId')
            ->orderBy('id', 'DESC')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($chat->isEmpty()) {
            return response([
                'message' => 'No chats found'
            ], 400);
        }

        Chat::where('from_id', $userId)
            ->where('to_id', $authUserId)
            ->where('is_read', Chat::READ_NO)
            ->where(function ($query) use ($authUserId) {
                $query->whereNull('readers')
                    ->orWhereRaw('NOT FIND_IN_SET(?, readers)', [$authUserId]);
            })
            ->update([
                'is_read' => Chat::READ_YES,
                'readers' => DB::raw("IFNULL(CONCAT_WS(',', readers, $authUserId), $authUserId)")
            ]);

        return response([
            'chat' => $chat->items(),
            'meta_count' => [
                'total_count' => $chat->total(),
                'current_page' => $chat->currentPage(),
                'total_pages' => $chat->lastPage(),
            ],
            'message' => 'Chats loaded successfully'
        ], 200);
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
        $chats = Chat::query()
            ->where('from_id', Auth::id())
            ->orWhere('to_id', Auth::id())
            ->get();

        $ids = [];

        foreach ($chats as $chat) {
            if ($chat->from_id != Auth::id()) {
                $ids[] = $chat->from_id;
            }
            if ($chat->to_id != Auth::id()) {
                $ids[] = $chat->to_id;
            }
        }

        $ids = array_unique($ids);

        $users = User::whereIn('id', $ids)->get();

        if ($users->isNotEmpty()) {
            return response([
                'chat' => $users,
                'message' => 'Chats list'
            ], 200);
        } else {
            return response([
                'chat' => [],
                'message' => 'Not found'
            ], 400);
        }
    }

    /**
     * @OA\Get(
     *      path="/chats/load-new-messages",
     *      operationId="loadNewMessages",
     *      tags={"chats"},
     *      security={{ "sanctum": {} }},
     *      summary="Check for new messages for the authenticated user",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="new_messages", type="array", @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="from_id", type="integer", example=2),
     *                  @OA\Property(property="to_id", type="integer", example=1),
     *                  @OA\Property(property="message", type="string", example="Hello!"),
     *                  @OA\Property(property="created_at", type="string", format="date-time")
     *              )),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Authentication error"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation failed"),
     *          )
     *      ),
     * )
     */
    public function loadNewMessages(Request $request)
    {
        $authUserId = Auth::id();

        $validator = validator($request->all(), [
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()
            ], 422);
        }

        $userId = $request->input('user_id');

        $newMessages = Chat::where('from_id', $userId)
            ->where('to_id', $authUserId)
            ->where('is_read', Chat::READ_NO)
            ->orderBy('created_at', 'asc')
            ->with('fromId', 'toId')
            ->get();
        if ($newMessages->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No new messages found',
                'chat' => []
            ], 200);
        }

        foreach ($newMessages as $message) {
            $readers = $message->readers ? explode(',', $message->readers) : [];
            if (!in_array($authUserId, $readers)) {
                $readers[] = $authUserId;
            }

            $message->readers = implode(',', $readers);
            $message->is_read = Chat::READ_YES;
            $message->save(['is_read', 'readers']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'New messages found',
            'chat' => $newMessages
        ], 200);
    }
}
