@extends('layout')

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <div class="alert alert-success" role="alert" style="display: none">
                    <h4 class="alert-heading">Статус выполненной операции!</h4>
                    <hr>
                    <p></p>
                </div>
            </div>
        </div>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4 pb-md-4">Действия с пользователями/ИНН</h1>
        <p>
            <a href="#" data-toggle="modal" data-target="#addUser" class="btn btn-outline-dark mr-4">Добавить пользователя</a>
            <a href="{{ route('list') }}" class="btn btn-outline-success mr-4">Список пользователей</a>
        </p>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Переводы средств</h1>
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-8">
                <form id="transfer" method="post" action="{{ route('api.v1.pay.transfer') }}">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="users">Выберите пользователя</label>
                                <select name="users" id="users" class="form-control" data-url="{{ route('api.v1.user.all') }}"></select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="inn">ИНН пользователей</label>
                                <input type="tel" name="inn" class="form-control" id="inn">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="deposit">Сумма для перевода</label>
                                <input type="tel" name="deposit" class="form-control" id="deposit" placeholder="123.12">
                            </div>
                        </div>

                        <div class="col text-center">
                            <button type="submit" class="btn btn-block btn-outline-primary ">Перевести средства</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUser" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel">Новый пользователь</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newUser" action="{{ route('api.v1.user.store') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Фамилия</label>
                            <input type="text" name="last_name" class="form-control" id="last_name">
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">Имя</label>
                            <input type="text" name="first_name" class="form-control" id="first_name">
                        </div>
                        <div class="form-group">
                            <label for="patronymic" class="col-form-label">Отчество</label>
                            <input type="text" name="patronymic" class="form-control" id="patronymic">
                        </div>
                        <div class="form-group">
                            <label for="balance" class="col-form-label">Баланс счета</label>
                            <input type="text" name="balance" class="form-control" id="balance">
                        </div>
                        <div class="form-group">
                            <label for="inn" class="col-form-label">Инн</label>
                            <select name="inn" id="inn" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMoney" role="dialog" aria-labelledby="addMoneyLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMoneyLabel">Зачислить средства пользователю(-ям)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newUser" action="{{ route('api.v1.user.store') }}" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Фамилия</label>
                            <input type="text" name="last_name" class="form-control" id="last_name">
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">Имя</label>
                            <input type="text" name="first_name" class="form-control" id="first_name">
                        </div>
                        <div class="form-group">
                            <label for="patronymic" class="col-form-label">Отчество</label>
                            <input type="text" name="patronymic" class="form-control" id="patronymic">
                        </div>
                        <div class="form-group">
                            <label for="inn" class="col-form-label">Инн</label>
                            <select name="inn" id="inn" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop