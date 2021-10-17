<?$this->layout('layout_page')?>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>

        </div>
        <?=$flash?>
        <form action="/securitychange?id=<?=$user['id']?>" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление эл. адреса и пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Email</label>
                                    <input type="text" id="simpleinput" class="form-control" name="email" value="<?=$user['email']?>">
                                </div>

                                <!-- password -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Текущий пароль</label>
                                    <input type="password" id="simpleinput" class="form-control" name="old_password">
                                </div>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Новый пароль</label>
                                    <input type="password" id="simpleinput" class="form-control" name="new_password">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning" type="submit">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    