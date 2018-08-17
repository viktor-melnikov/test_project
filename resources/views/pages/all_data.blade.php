@extends('layout')

@section('content')

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4 pb-md-4">Просмотр пользователей</h1>
        <p>
            <a href="{{ route('index') }}" class="btn btn-outline-dark mr-4">На главную</a>
        </p>
    </div>


    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Отчество</th>
                        <th scope="col">Баланс</th>
                        <th scope="col">Номер счета</th>
                        <th scope="col">Инн</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->patronymic }}</td>
                            <td>{{ $user->balance }}</td>
                            <td>{{ $user->account_number }}</td>
                            <td>{{ $user->inn->inn }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop