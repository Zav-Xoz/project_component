<?$this->layout('layout_page')?>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Добавить соцсети
            </h1>



        </div>
        <form action="/editcontacts?id=<?=$user['id']?>" method="post">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Социальные сети</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- vk -->
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                <span class="icon-stack fs-xxl">
                                                    <i class="base-7 icon-stack-3x" style="color:#4680C2"></i>
                                                    <i class="fab fa-vk icon-stack-1x text-white"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 bg-transparent pl-0" name="vk" value="<?=$user['vk']?>">
                                    </div>
                                </div>
                                <div class="col-md-4">


                                    <!-- telegram -->
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                <span class="icon-stack fs-xxl">
                                                    <i class="base-7 icon-stack-3x" style="color:#38A1F3"></i>
                                                    <i class="fab fa-telegram icon-stack-1x text-white"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 bg-transparent pl-0" name="telegram" value="<?=$user['telegram']?>">
                                    </div>
                                </div>
                                <div class="col-md-4">


                                    <!-- instagram -->
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                <span class="icon-stack fs-xxl">
                                                    <i class="base-7 icon-stack-3x" style="color:#E1306C"></i>
                                                    <i class="fab fa-instagram icon-stack-1x text-white"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 bg-transparent pl-0" name="instagram" value="<?=$user['instagram']?>">
                                        <input type="hidden" name="id" value="<?=$user['id']?>">
                                    </div>
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-success" type="submit">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    