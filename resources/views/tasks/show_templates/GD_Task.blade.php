@extends('tasks.show_templates._default')

@section('user_task')
    @include('components.image', ['img' => $data['image'], 'name' => 'Graph'])
    @include('components.table_graph', ['graph' => $data['graph']])
@endsection

@section('decision')
    Для решения этой задачи необходимо попытаться сопоставить рисунок и таблицу.
@endsection

@section('form')

@endsection


@section('answer')

@endsection