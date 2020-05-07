<?php

namespace App\Http\Controllers;


use App\Models\GroupTask;
use App\Models\Task;
use App\Models\UserTask;
use App\Tasks\TaskCreator;
use App\Tasks\TaskInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index($group_id, $title = 'Задачи')
    {
        $groups = GroupTask::all();
        $tasks = Task::with('userTask')
            ->whereGroupId($group_id)->get();
        return view('tasks.index', compact('group_id', 'groups', 'tasks', 'title'));
    }

    public function show($id)
    {
        $task = Task::with('group')->find($id);
        $taskCreator = (new TaskCreator($task))->getTask();
        $this->getUserTask($taskCreator, $task->id, $task->group_id);
        $taskCreator->setUserTask($task->task_text);
        return view($taskCreator->getView(), $taskCreator->getData());
    }

    public function nextTask(Request $request, $id)
    {
        $success = $request->get('success', 0);
        $task = Task::find($id);
        $user_task = UserTask::NextTaskByUser($task->id, Auth::id())->first();

        if ($success) {
            $user_task->status = UserTask::SOLVED;
        } else {
            $user_task->hint_use = 1;
        }

        $user_task->save();
        return redirect()->route('tasks.show', $task->id);
    }

    public function getUserTask(TaskInterface $creator, $task_id, $group_id)
    {
        $user_id = Auth::id();
        $user_task = UserTask::NextTaskByUser($task_id, $user_id)->first();
        if (empty($user_task)) {
            $data = $creator->initData();
            $user_task = UserTask::create(compact('task_id', 'user_id', 'group_id', 'data'));
        } else {
            $creator->setData($user_task->data);
        }
        return $user_task;
    }

    public function checkAnswer(Request $request, $id)
    {
        $task = Task::find($id);
        $taskCreator = (new TaskCreator($task))->getTask();
        $this->getUserTask($taskCreator, $task->id, $task->group_id);
        return $taskCreator->checkAnswer($request);
    }
}
