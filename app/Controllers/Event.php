<?php

namespace App\Controllers;

use App\Services\Event\EventService;

class Event extends BaseController
{
    protected $eventService;

    public function __construct()
    {
        if (!session()->get('isLoggedIn')) {
            header('Location: ' . base_url('/'));
            exit;
        }

        $this->eventService = service('eventService');
    }

    public function index()
    {
        return view('event', [
            'events' => $this->eventService->getAll()
        ]);
    }

    public function saveEvent()
    {
        $file = $this->request->getFile('event_file');

        $result = $this->eventService->save(
            $this->request->getPost(),
            $file
        );

        if ($result === true) {
            return redirect()->to('/event')
                             ->with('success', 'Event saved successfully!');
        }

        return redirect()->back()
                         ->with('errors', $result);
    }

    public function delete($id)
    {
        $this->eventService->delete($id);

        return redirect()->to('/event')
                         ->with('success', 'Event deleted successfully!');
    }

    public function update($id)
    {
        $file = $this->request->getFile('event_file');

        $result = $this->eventService->update(
            $id,
            $this->request->getPost(),
            $file
        );

        if ($result === true) {
            return redirect()->to('/event')
                             ->with('success', 'Event updated successfully!');
        }

        return redirect()->back()
                         ->with('errors', $result);
    }
}