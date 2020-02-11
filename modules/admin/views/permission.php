<div class="box">
    <div class="box-body">
        <form action="<?php echo site_url('admin/permission/' . $role); ?>" method="post" >
            <div class="form-group">
                <label>User Role</label>
                <?php echo form_dropdown('role', get_user_roles(), $role, array('class' => 'form-control', 'id' => 'role')); ?>
            </div>

            <div class="accordion" id="modulePermission">
                <div class="row">
                    <?php
                    foreach(getModules() as $key => $module)
                    {
                        ?><div class="col-sm-12">
                            <div class="card mb-3">
                                <div class="card-header cus-card-header" id="heading<?php echo $module->module_name; ?>">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#module_<?php echo $module->module_name; ?>" aria-expanded="true" aria-controls="module_<?php echo $module->module_name; ?>">
                                        <strong><?php echo $module->display_name; ?></strong>
                                    </button>
                                </div>
                                <div id="module_<?php echo $module->module_name; ?>" class="collapse <?php if($key == 0) { ?>show<?php } ?>" aria-labelledby="heading<?php echo $module->module_name; ?>" data-parent="#modulePermission">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        $actions = getActions(array('module_id' => $module->module_id));
                                        if($actions)
                                        {
                                            foreach($actions as $action)
                                            {
                                                ?><li class="list-group-item">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"  id="<?php echo $module->module_name; ?>_<?php echo $action->action_name; ?>" class="custom-control-input selectall" name="<?php echo $module->module_name; ?>[]" <?php if (has_permission($module->module_name, $action->action_name, $role)) { ?> checked="checked" <?php } ?> value="<?php echo $action->action_name; ?>">
                                                        <label class="custom-control-label" for="<?php echo $module->module_name; ?>_<?php echo $action->action_name; ?>"><?php echo $action->display_name; ?></label>
                                                    </div>
                                                </li><?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn button-primary-cus">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        $('#role').bind('change', function () {
            var role = $(this).val(); // get selected            
            var url = base_url + 'admin/permission/' + role;
            if(url){ window.location = url; }
            return false;
        });
    });
</script>
