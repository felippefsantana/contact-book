<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function index() {
        $contacts = Contact::all();

        return $contacts;
    }

    public function store(Request $request) {
        $newContact = new Contact;

        $newContact->name = $request->contact['name'];
        $newContact->email = $request->contact['email'];
        $newContact->phone = $request->contact['phone'];

        $newContact->save();

        return $newContact;
    }

    public function show(Request $request) {
        $contact = Contact::findOrFail($request->id);
        if(!$contact) {
            return response()->json(['error' => 'Contato não encontrado']);
        }

        return $contact;
    }

    public function update(Request $request) {
        $contact = Contact::findOrFail($request->id);
        if(!$contact) {
            return response()->json(['error' => 'Contato não encontrado']);
        }
        
        $data = $request->all();

        $update = $contact->update($data);
        return response()->json([
            'message' => 'Contato atualizado com sucesso',
            'contato' => $contact
        ]);
    }

    public function destroy(Request $request) {
        $contact = Contact::findOrFail($request->id);
        if(!$contact) {
            return response()->json(['error' => 'Não foi possível excluir o contato com esse ID']);
        }
        $contact->delete($contact);
        return response()->json(['message' => 'Contato excluído com sucesso']);
    }
}
