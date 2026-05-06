<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class TaskAttachmentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'attachment' => 'required|file|max:10240',
        ]);

        $file = $request->file('attachment');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
        $path = $file->storeAs('task_attachments/' . $task->id, $filename, 'public');

        $attachment = TaskAttachment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'filename' => $filename,
            'original_name' => $originalName,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
        ]);

        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'File Uploaded',
            'description' => "Uploaded file: {$originalName}"
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(Task $task, TaskAttachment $attachment)
    {
        // Ensure the attachment belongs to the given task
        if ($attachment->task_id != $task->id) {
            abort(404, 'Attachment not found for this task.');
        }

        // Authorization: only admin or the uploader can delete
        if (Auth::user()->role !== 'Admin' && Auth::id() !== $attachment->user_id) {
            abort(403);
        }

        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();

        ActivityLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'File Deleted',
            'description' => "Deleted file: {$attachment->original_name}"
        ]);

        return back()->with('success', 'File deleted successfully.');
    }

    public function download(Task $task, TaskAttachment $attachment)
    {
        // Ensure the attachment belongs to the given task
        if ($attachment->task_id != $task->id) {
            abort(404, 'Attachment not found for this task.');
        }

        return Storage::disk('public')->download($attachment->path, $attachment->original_name);
    }
}