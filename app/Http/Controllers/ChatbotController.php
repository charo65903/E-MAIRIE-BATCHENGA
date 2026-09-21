<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function repondre(Request $request, ChatbotService $chatbot)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        return response()->json([
            'reponse' => $chatbot->repondre($request->message),
        ]);
    }
}
