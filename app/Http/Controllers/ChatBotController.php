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

        $selectRespuesta = ChatBot::where('queries', '=', $request->text)
            ->select('replies')
            ->get();

        if (count($selectRespuesta) > 0) {
            return response()->json($selectRespuesta[0]->replies, status: 200);
        } else {
            return response()->json('¡Lo siento, no puedo ayudarte con este inconveniente!', status: 200);
        }
    }

    public function chat_bot_welcome_init()
    {
        $selectSaludo = ChatBot::where('queries', '=', 'saludo')
            ->select('replies')
            ->get();
        $selectAllPreguntas = ChatBot::select('queries')
            ->where('queries', 'NOT LIKE', 'saludo')
            ->get();
        $tabla = '';
        foreach ($selectAllPreguntas as $datos) {
            $tabla = $tabla . '<td class="btn btn-info" onclick="buscar(`' . $datos->queries . '`)">' . $datos->queries . '</td>';
        }
        return response()->json([
            'saludo' => $selectSaludo[0]->replies,
            'preguntas' => $tabla
        ], status: 200);
    }

    public function list_chat_bot()
    {
        $selectChatBot = ChatBot::all();

        $arrayDatos = [];

        foreach ($selectChatBot as $datos) {
            $botones = '<button class="btn btn-primary btn-xs" title="Editar" onclick="updateChatBot(' . $datos->id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->id . ')"><i class="fa fa-trash"></i></button>';
            $arrayDatos[] = [
                '0' => $botones,
                '1' => $datos->queries,
                '2' => $datos->replies
            ];
        }
        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($arrayDatos), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($arrayDatos), //enviamos el total de registros a visualizar
            "aaData" => $arrayDatos
        ];
        return response()->json($results, status: 200);
    }
    public function insert_chat_bot(Request $request)
    {
        $this->validate($request, [
            'pregunta' => 'required|string',
            'respuesta' => 'required|string'
        ]);
        $newChatBot = new ChatBot;
        $newChatBot->queries = $request->pregunta;
        $newChatBot->replies = $request->respuesta;
        $newChatBot->save();
        return response()->json('Completed', status: 200);
    }
    public function mostrar_chat_bot(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        return response()->json(ChatBot::find($request->id), status: 200);
    }

    public function update_chat_bot(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'pregunta' => 'required|string',
            'respuesta' => 'required|string'
        ]);
        $selectChatBot = ChatBot::find($request->id);
        $selectChatBot->queries = $request->pregunta;
        $selectChatBot->replies = $request->respuesta;
        $selectChatBot->save();
        return response()->json('Completed', status: 200);
    }
    public function delete_chat_bot(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        ChatBot::destroy($request->id);
        return response()->json('Completed', status: 200);
    }
}
