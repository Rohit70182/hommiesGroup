<?php
namespace Modules\Chat\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Modules\Chat\Entities\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $latestChats = Chat::select('from_id', 'to_id')->orderBy('created_at', 'DESC')->get();
        
        $userlist = User::where('id', '!=', Auth::user()->id)->get();
        
        $sortChat = [];
        
        if (! empty($latestChats)) {
            foreach ($latestChats as $latestChat) {
                
                if ($latestChat->from_id == Auth::user()->id) {
                    $sortChat[] = $latestChat->to_id;
                } else {
                    $sortChat[] = $latestChat->from_id;
                }
            }
        }
        
        $sortChat = array_unique($sortChat);
        
        foreach ($userlist as $user) {
            if (! in_array($user->id, $sortChat)) {
                array_push($sortChat, $user->id);
            }
        }
        $nuserlist = [];
        foreach ($sortChat as $list) {
            $nuserlist[] = User::where('id', $list)->first();
        }

        return view('chat::chat', compact('nuserlist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable display chat between two users
     */
    public function chat(Request $request, $id)
    {
        $messages = Chat::where('from_id', '=', Auth::user()->id)->where('to_id', '=', $id)
            ->orWhere('from_id', '=', $id)
            ->where('to_id', '=', Auth::user()->id)
            ->get();

        $chat = Chat::where('from_id', '=', $id)->where('to_id', '=', Auth::user()->id)->update([
            'is_read' => Chat::READ_YES
        ]);
        
        $formatedMessages = [];
        foreach($messages as $message) {
            
            $timeMessage = $message->created_at;
            $timeMessage = explode(" ",$timeMessage);
            $messageDate = $timeMessage[0];
            
            $formatedMessages[$messageDate][] = $message;
        }

        $latestChats = Chat::select('from_id', 'to_id')->orderBy('created_at', 'DESC')->get();

        $userlist = User::where('id', '!=', Auth::user()->id)->get();

        $sortChat = [];

        if (! empty($latestChats)) {
            foreach ($latestChats as $latestChat) {

                if ($latestChat->from_id == Auth::user()->id) {
                    $sortChat[] = $latestChat->to_id;
                } else {
                    $sortChat[] = $latestChat->from_id;
                }
            }
        }

        $sortChat = array_unique($sortChat);

        foreach ($userlist as $user) {
            if (! in_array($user->id, $sortChat)) {
                array_push($sortChat, $user->id);
            }
        }
        $nuserlist = [];
        foreach ($sortChat as $list) {
            $nuserlist[] = User::where('id', $list)->first();
        }

        return view('chat::chat', compact("formatedMessages", "nuserlist"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $id)
    {
        if (! empty($request->input('message')) && empty($request->file('file'))) {
            $messageType = Chat::ONLY_MESSAGE;
        } else if (empty($request->input('message')) && ! empty($request->file('file'))) {
            $messageType = Chat::ONLY_IMAGE;
        }

        $chat = new Chat();
        $chat->message = $request->input('message');
        $chat->from_id = Auth::id();
        $chat->to_id = $id;
        $chat->readers = Auth::id() . ',' . $id;
        $chat->message_type = $messageType;
        $chat->type_id = Chat::ADMIN_MESSAGE;

        request()->validate([
            'file' => 'mimes:jpeg,jpg,png'
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            ;
            $file->move('public/uploads', $filename);
            $chat->file = $filename;
        }

        if ($chat->save()) {
            if (! empty($chat->file)) {
                $image = url('public/uploads/' . $chat->file);
            } else {
                $image = '';
            }
            
            $time = $chat->created_at;
            $dateTime = new \DateTime($time);
            $time = $dateTime->format('h:i a');
            
            $data = [
                'message' => $chat->message,
                'file' => $image,
                'time' => $time
            ];

            return $data;
        }
    }
    
    /**
     * Show updated user list
     * 
     * @param Request $request
     * @return Renderable sending request to get updated user list
     */
    
    public function getUserList() {
        
        $latestChats = Chat::select('from_id', 'to_id')->orderBy('created_at', 'DESC')->get();
        
        $userlist = User::where('id', '!=', Auth::user()->id)->get();
        
        $sortChat = [];
        
        if (! empty($latestChats)) {
            foreach ($latestChats as $latestChat) {
                
                if ($latestChat->from_id == Auth::user()->id) {
                    $sortChat[] = $latestChat->to_id;
                } else {
                    $sortChat[] = $latestChat->from_id;
                }
            }
        }
        
        $sortChat = array_unique($sortChat);
        
        foreach ($userlist as $user) {
            if (! in_array($user->id, $sortChat)) {
                array_push($sortChat, $user->id);
            }
        }
        $nuserlist = [];
        foreach ($sortChat as $list) {
            $nuserlist[] = User::where('id', $list)->first();
        }
        
        $data = [];
        
        foreach($nuserlist as $nuser) {
            // get the url of the chat
            $href = url('chat/show/'.$nuser->id);
            
            // get the image of the user
            if(!empty($nuser->image)) {
                $image = url('public/uploads/'.$nuser->image);
            } else {
                $image = url('public/assets/images/user.png');
            }
            
            $data[] = [
                'id' => $nuser->id,
                'name' => $nuser->name,
                'href' => $href,
                'image' => $image,
                'count' => $nuser->unread_count,
            ];
        }
        
        return $data;
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Renderable sending request to get new messages if available
     */
    public function getMessage($id)
    {
        $messages = Chat::where('from_id', '=', $id)->where('to_id', '=', Auth::user()->id)
            ->where('is_read', Chat::READ_NO)
            ->latest()
            ->first();

        $chat = Chat::where('from_id', '=', $id)->where('to_id', '=', Auth::user()->id)->update([
            'is_read' => Chat::READ_YES
        ]);

        if (! empty($messages->file)) {
            $image = url('public/uploads/' . $messages->file);
        } else {
            $image = '';
        }

        $data = [];

        if ($messages) {
            $time = $messages->created_at;
            $dateTime = new \DateTime($time);
            
            $time = $dateTime->format('h:i a');
            $data = [
                'message' => $messages->message,
                'time' => $time,
                'image' => $image
            ];
        }

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('chat::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
