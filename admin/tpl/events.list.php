<?php

if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)) die;

$sts = [-1 => ['icon' =>'fa fa-calendar-times-o fa-lg', 'color'=>'text-danger'],
         0 => ['icon' =>'fa fa-calendar-o fa-lg', 'color'=>'text-secondary'],
         1 => ['icon' =>'fa fa-calendar-check-o fa-lg', 'color'=>'text-success']];

$e_res = $DB->query("SELECT *, DATE_FORMAT(`dt`, '%d.%m.%Y') AS `d`, DATE_FORMAT(`dt`, '%H:%i') AS `t` FROM `events` WHERE `org_id`".($U['org_id'] ? "=".$U['org_id'] : ">0")." AND `city_id`".($U['city_id'] ? "=".$U['city_id'] : ">0")." ORDER BY `dt` DESC");

$uri_status_up = 'task=events&p=status-up&i=';
$uri_status_dn = 'task=events&p=status-dn&i=';

?>
        <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip(); 

            $('#event-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);    // Button that triggered the modal
                var url = button.data('url');
                var modal = $(this);

                $.getJSON('./event.php?' + url, function(data) {

                    for(var i = 1; i <= <?=NUM_IMAGES;?>; i++)
                    {
                        if(data['img_ext_'+i])
                        {
                            //modal.find('.card-img-top').attr('src', '<?=UPLOAD_DIR;?>/'+data['id']+'.'+data['img_ext']);
                            //modal.find('.card-img-top').show();
                            modal.find('#card-img-'+i).attr('src', '<?=UPLOAD_DIR;?>/'+data['id']+'-'+i+'.'+data['img_ext_'+i]);
                            modal.find('#card-img-'+i).show();
                        }
                        else
                        {
                            //modal.find('.card-img-top').removeAttr('src');
                            //modal.find('.card-img-top').hide();
                            modal.find('#card-img-'+i).removeAttr('src');
                            modal.find('#card-img-'+i).hide();
                        }
                    }

                    modal.find('#event-title').html(data['title']);
                    modal.find('#event-d').html(data['d']);
                    modal.find('#event-t').html(data['t']);
                    modal.find('#event-city').html(data['city_title']);
                    modal.find('#event-lang').html(data['lang_title']);
                    modal.find('#event-game').html(data['game_title']);
                    modal.find('#event-price').html(data['price']);
                    modal.find('#event-min').html(data['count_min']);
                    modal.find('#event-max').html(data['count_max']);
                    modal.find('#event-free').html(data['count_free']);
                    modal.find('#event-paid').html(data['count_paid']);
                    modal.find('#event-addr').html(data['addr']);
                    modal.find('#event-descr').html(data['descr']);
                    modal.find('#event-long_descr').html(data['long_descr']);

                    if(data['map'])
                    {
                        modal.find('#event-map').attr('href', data['map']);
                        modal.find('#event-map').show();
                    }
                    else
                    {
                        modal.find('#event-map').hide();
                    }

                    if(data['link'])
                    {
                        modal.find('#event-link').attr('href', data['link']);
                        modal.find('#event-link').show();
                    }
                    else
                    {
                        modal.find('#event-link').hide();
                    }
                });
            });
        });
        </script>

        <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Карточка мероприятия</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;<!--<i class="fa fa-close fa-lg"></i>--></span>
                        </button>
                    </div>
                    <?php for($i = 1; $i <= NUM_IMAGES; $i++): ?>
                    <img class="card-img-top" id="card-img-<?=$i;?>">
                    <?php endfor; ?>
                    <div class="modal-body ">
                        <div class="form-group">
                            <strong>Наименование: </strong><span id="event-title"></span>
                        </div>
                        <div class="form-group">
                            <strong>Дата и время: </strong><span id="event-d"></span><strong> в </strong><span id="event-t"></span>
                        </div>
                        <div class="form-group">
                            <strong>Город: </strong><span id="event-city"></span>
                        </div>
                        <div class="form-group">
                            <strong>Язык: </strong><span id="event-lang"></span>
                        </div>
                        <div class="form-group">
                            <strong>Тип мероприятия: </strong><span id="event-game"></span> 
                        </div>
                        <div class="form-group">
                            <strong>Стоимость: </strong><span id="event-price"></span> <?=RUB;?>
                        </div>
                        <div class="form-group">
                            <strong>Минимальное количество билетов: </strong><span id="event-min"></span>
                        </div>
                        <div class="form-group">
                            <strong>Максимальное количество билетов: </strong><span id="event-max"></span>
                        </div>
                        <div class="form-group">
                            <strong>Бесплатных билетов: </strong><span id="event-free"></span>
                        </div>
                        <div class="form-group">
                            <strong>Выкупленных билетов: </strong><span id="event-paid"></span>
                        </div>
                        <div class="form-group">
                            <strong>Адрес проведения: </strong><span id="event-addr"></span>
                        </div>
                        <div class="form-group">
                            <strong>Краткое описание: </strong><span id="event-descr"></span>
                        </div>
                        <div class="form-group">
                            <strong>Длинное описание: </strong><span id="event-long_descr"></span>
                        </div>
                        <div class="form-group">
                            <a href="" id="event-map"><strong>Карта </strong></a>
                        </div>
                        <div class="form-group">
                            <a href="" id="event-link"><strong>Отчет</strong></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <p><h3><small>Список мероприятий</small></h3></p>
        <div class="table-responsive-xl">
        <table class="table table-striped table-hover table-sm">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="text-center"><i class="fa fa-calendar fa-lg"></i></th>
              <th scope="col" class="text-center"><i class="fa fa-clock-o fa-lg"></i></th>
              <th scope="col" class="text-center">Тип</th>
              <?php if(!$U['city_id']): ?>
              <th scope="col" class="text-center"><i class="fa fa-fort-awesome fa-lg"></i></th>
              <?php endif; ?>
              <th scope="col" class="text-center"><i class="fa fa-language fa-lg"></i></th>
              <th scope="col" class="text-center"><i class="fa fa-edit fa-lg"></i></th>
              <th scope="col" class="text-center"><i class="fa fa-futbol-o fa-lg"></i></th>
              <th scope="col" class="text-center"><i class="fa fa-map-o fa-lg"></i></th>
              <?php if(!$U['org_id']): ?>
              <th scope="col">Организатор</th>
              <?php endif; ?>
              <th scope="col" class="text-center"><i class="fa fa-bell fa-lg"></i></th>
              <th scope="col" class="text-right"><a href="#" data-toggle="tooltip" title="Стоимость посещения"><?=RUB;?></a></th>
              <th scope="col" class="text-right"><i class="fa fa-thermometer-0 fa-lg"></i></th>
              <th scope="col" class="text-right"><i class="fa fa-thermometer-4 fa-lg"></i></th>
              <th scope="col" class="text-right"><i class="fa fa-money fa-lg"></i></th>
              <th scope="col" class="text-right">Беспл.</th>
              <th scope="col" class="text-center"><i class="fa fa-camera fa-lg"></i></th>
              <th scope="col" class="text-center">Действия</th>
            </tr>
          </thead>
          <tbody>
          <?php while($e = $e_res->fetch_assoc()): ?>
            <!--<tr class="<?=($e['status'] > 0 ? 'table-success' : ($e['status'] < 0 ? 'table-danger' : ''));?>">-->
            <tr>
              <td class="text-center"><?=$e['d'];?></td>
              <td class="text-center"><?=$e['t'];?></td>
              <td class="text-center"><?=$C_games[$e['game_id']]['title'];?></td>
              <?php if(!$U['city_id']): ?>
              <td class="text-center"><?=$C_cities[$e['city_id']]['title'];?></td>
              <?php endif; ?>
              <td class="text-center"><?=$C_langs[$e['lang_id']]['title'];?></td>
              <td class="text-center"><?php if($e['status'] == 0): ?><a href="./?<?=url_query_make('task=events&p=edit&i='.$e['id'], false);?>" data-toggle="tooltip" class="text-primary" title="Редактировать мероприятие"><i class="fa fa-pencil fa-lg"></i></a><?php endif; ?></td>
              <td><a href="javascript: void(0);" data-toggle="modal" data-target="#event-modal" data-url="<?=url_query_make('i='.$e['id']);?>"><span data-toggle="tooltip" title="Просмотреть карточку мероприятия"><?=$e['title'];?></span></a></td>
              <td class="text-center"><?php if($e['map']): ?><a href="<?=$e['map'];?>" data-toggle="tooltip" class="text-info" title="Открыть карту" target="_blank"><i class="fa fa-map-marker fa-lg"></i></a><?php endif; ?></td>
              <?php if(!$U['org_id']): ?>
              <td><?=$C_orgs[$e['org_id']]['title'];?></td>
              <?php endif; ?>
              <td class="text-center"><span class="<?=$sts[$e['status']]['color'];?>" data-toggle="tooltip" title="<?=$C_statuses[$e['status']]['title'];?>"><i class="<?=$sts[$e['status']]['icon'];?>"></i></span></td>
              <td class="text-right"><?=$e['price'];?></td>
              <td class="text-right"><span class="badge badge-warning"><?=$e['count_min'];?></span></td>
              <td class="text-right"><span class="badge badge-success"><?=$e['count_max'];?></span></td>
              <td class="text-right"><span class="badge badge-<?=($e['count_paid'] < $e['count_min'] ? 'danger' : ($e['count_paid'] >= $e['count_max'] ? 'success' : 'warning'));?>"><?=$e['count_paid'];?></span></td>
              <td class="text-right"><?=$e['count_free'];?></td>
              <td class="text-center"><?php if($e['link']): ?><a href="<?=$e['link'];?>" data-toggle="tooltip" class="text-info" title="Открыть отчет о мероприятии" target="_blank"><i class="fa fa-link fa-lg"></i></a><?php endif; ?></td>
              <td class="text-center">
              <?php if($e['status'] < 0): ?>
                <!--<a href="./?<?=url_query_make('task=events&p=remove&i='.$e['id'], false);?>" onClick="return confirm('Подтвердите удаление мероприятия?');" data-toggle="tooltip" class="text-muted" title="Удалить мероприятие"><i class="fa fa-trash-o fa-lg"></i></a>-->
              <?php elseif($e['status'] > 0): ?>
                <a href="./?<?=url_query_make('task=events&p=status-dn&i='.$e['id'], false);?>" onClick="return confirm('Пожалуйста, подтвердите отмену мероприятия!');" data-toggle="tooltip" class="text-danger" title="Отменить мероприятие"><i class="fa fa-calendar-times-o fa-lg"></i></a>
              <?php else: ?>
                <a href="./?<?=url_query_make('task=events&p=status-dn&i='.$e['id'], false);?>" onClick="return confirm('Пожалуйста, подтвердите отмену мероприятия!');" data-toggle="tooltip" class="text-danger" title="Отменить мероприятие"><i class="fa fa-calendar-times-o fa-lg"></i></a>
                <a href="./?<?=url_query_make('task=events&p=status-up&i='.$e['id'], false);?>" onClick="return confirm('Подтвердить проведение мероприятия?');" data-toggle="tooltip" class="text-success" title="Подтвердить мероприятие"><i class="fa fa-calendar-check-o fa-lg"></i></a>
              <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        </div>