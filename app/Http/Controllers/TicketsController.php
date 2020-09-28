<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Ticket;

class TicketsController extends Controller
{
    public function store(TicketFormRequest $request)
    {
        $slug = uniqid();
        $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug
        ));

        $ticket->save();

        $data = array(
            'ticket' => $slug,
        );

        Mail::send('emails.ticket', $data, function($message) {
            $message->from('joshuaminja5@gmail.com', 'YouForum');

            $message->to('joshuaminja5@gmail.com')->subject('There is a new post! Check it out');
        });

        return redirect('/contact')->with('status', 'Your post is created successfully! Its ID is : '.$slug);
    }

    public function index()
    {
        $tickets = Ticket::all();

        return view('tickets.index', compact('tickets'));

    }

    public function show($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();

        $comments = $ticket->comments()->get();

        return view('tickets.show', compact('ticket', 'comments'));
    }

    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();

        return view('tickets.edit', compact('ticket'));
    }

    public function update($slug, TicketFormRequest $request)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');

        if($request->get('status') != null) {
            $ticket->status = 0;
        } else {
            $ticket->status = 1;
        }
        
        $ticket->save();

        return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The post with ID '.$slug.' is updated successfully!');
    }

    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->delete();

        return redirect('/tickets')->with('status', 'The post with ID '.$slug.' is deleted successfully!');
    }
}
