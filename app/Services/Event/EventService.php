<?php

namespace App\Services\Event;

use App\Models\EventModel;

class EventService
{
    protected $model;

    public function __construct()
    {
        $this->model = new EventModel();
    }

    public function getAll()
    {
        return $this->model
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }

    public function save($post, $file)
    {
        if (!$file || !$file->isValid()) {
            return ['Invalid file upload.'];
        }

        if ($file->getSize() > 2048000) {
            return ['File must not exceed 2MB.'];
        }

        $allowed = ['jpg','jpeg','png','pdf'];
        $ext = strtolower($file->getExtension());

        if (!in_array($ext, $allowed)) {
            return ['Only JPG, PNG, PDF allowed.'];
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/events', $newName);

        $this->model->save([
            'so_number'  => $post['so_number'],
            'event_name' => $post['event_name'],
            'event_date' => $post['event_date'],
            'event_file' => $newName
        ]);

        return true;
    }

    public function delete($id)
    {
        $event = $this->model->find($id);

        if ($event && file_exists(FCPATH . 'uploads/events/' . $event['event_file'])) {
            unlink(FCPATH . 'uploads/events/' . $event['event_file']);
        }

        $this->model->delete($id);
    }

    public function update($id, $post, $file)
    {
        $event = $this->model->find($id);

        if (!$event) {
            return ['Event not found.'];
        }

        $data = [
            'so_number'  => $post['so_number'],
            'event_name' => $post['event_name'],
            'event_date' => $post['event_date']
        ];

        if ($file && $file->isValid()) {

            if ($file->getSize() > 2048000) {
                return ['File must not exceed 2MB.'];
            }

            $allowed = ['jpg','jpeg','png','pdf'];
            $ext = strtolower($file->getExtension());

            if (!in_array($ext, $allowed)) {
                return ['Only JPG, PNG, PDF allowed.'];
            }

            if (file_exists(FCPATH . 'uploads/events/' . $event['event_file'])) {
                unlink(FCPATH . 'uploads/events/' . $event['event_file']);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/events', $newName);

            $data['event_file'] = $newName;
        }

        $this->model->update($id, $data);

        return true;
    }
}