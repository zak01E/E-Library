<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserHelpController extends Controller
{
    public function index()
    {
        return view('user.help.index');
    }

    public function faq()
    {
        return view('user.help.faq');
    }

    public function guide()
    {
        return view('user.help.guide');
    }

    public function tutorials()
    {
        return view('user.help.tutorials');
    }

    public function contact()
    {
        return view('user.help.contact');
    }

    public function sendContact(Request $request)
    {
        // Logique d'envoi de contact
        return redirect()->route('user.help.contact')->with('success', 'Message envoyé avec succès');
    }

    public function viewTicket($id)
    {
        return view('user.help.ticket', compact('id'));
    }

    public function createTicket(Request $request)
    {
        // Logique de création de ticket
        return redirect()->route('user.help.index')->with('success', 'Ticket créé avec succès');
    }

    public function replyTicket(Request $request, $id)
    {
        // Logique de réponse au ticket
        return redirect()->route('user.help.ticket.view', $id)->with('success', 'Réponse ajoutée');
    }

    public function searchHelp(Request $request)
    {
        $query = $request->get('q');
        return view('user.help.search', compact('query'));
    }
}