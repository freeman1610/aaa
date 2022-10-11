<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatBot;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function chat_bot_welcome(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string'
        ]);

        $selectRespuesta = ChatBot::where(
            'queries',
            'LIKE',
            '%' . $request->text . '%'
        )
            ->select('replies')
            ->get();

        if (count($selectRespuesta) > 0) {
            return response()->json($selectRespuesta[0]->replies, status: 200);
        } else {
            return response()->json('¡Lo siento, no puedo ayudarte con este inconveniente!', status: 200);
        }
    }
}
