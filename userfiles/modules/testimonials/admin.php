<?php must_have_access(); ?>

<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>

<?php if (isset($params['backend'])): ?>
    <module type="admin/modules/info"/>
<?php endif; ?>

<div class="card style-1 mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <img src="<?php echo $module_info['icon']; ?>" class="module-icon-svg-fill"/> <strong><?php echo $module_info['name']; ?></strong>
        </h5>
    </div>

    <div class="card-body pt-3">

        <style type="text/css">
            #testimonials-list tbody tr {
                cursor: move;
                cursor: -moz-grab;
                cursor: -webkit-grab;
                cursor: grab;
            }

            #testimonials-list.dragging {
                cursor: -moz-grabbing;
                cursor: -webkit-grabbing;
                cursor: grabbing;
            }

            #testimonials-list .ui-sortable-helper {
                width: 100% !important;
                display: block;
                background: white;
            }

            #testimonials-list .ui-sortable-placeholder {
                background: rgba(204, 199, 191, 1);
                outline: 1px dotted rgba(186, 192, 216, 1);
                min-height: 100px;
                visibility: visible !important;
            }

            #testimonials-list .ui-sortable-helper td + td * {
                color: transparent !important;
            }

            #testimonials-list .ui-sortable-helper td {
                display: inline-block;
                border: none;

            }

            .previewquote {
                display: block;
                width: 60px;
                height: 60px;
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                background-color: #efecec;
                margin-bottom: 12px;
            }

            .testimonial-client-image {
                max-width: 100px;
                max-height: 100px;
            }
        </style>

        <script>
            function saveChanges() {
                $('form#add-testimonial-form').submit()
            }
        </script>

        <?php
        $limit = get_option('limit', $params['id']);
        $testimonials_limit = get_option('testimonials_limit', $params['id']);

        if ($limit == false or $limit == '') {
            $limit = 250;
        }


        $interval = get_option('interval', $params['id']);

        if ($interval == false or $interval == '') {
            $interval = 5;
        }

        if ($interval < 0.2) {
            $interval = 0.2;
        }

        $openquote = get_option('openquote', $params['id']);
        $closequote = get_option('closequote', $params['id']);
        ?>

        <script>
            $(document).ready(function () {
                OpenQuote = mw.uploader({
                    filetypes: "images",
                    element: "#openquote",
                    multiple: false
                });
                CloseQuote = mw.uploader({
                    filetypes: "images",
                    element: "#closequote",
                    multiple: false
                });

                $(OpenQuote).bind("FileUploaded", function (a, b) {
                    mw.$("#openquote-preview img").attr("src", b.src);
                    mw.$("[name='openquote']").val(b.src).trigger('change');
                });
                $(CloseQuote).bind("FileUploaded", function (a, b) {
                    mw.$("#closequote-preview img").attr("src", b.src);
                    mw.$("[name='closequote']").val(b.src).trigger('change');
                });

            });
        </script>

        <div class="<?php if ($from_live_edit): ?><?php else: ?><?php endif; ?>">
            <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
                <a class="btn btn-outline-secondary justify-content-center active js-list-testimonials" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> List of Testimonials</a>
                <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
                <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>
                <a class="btn btn-outline-secondary justify-content-center js-add-new-testimonials" data-toggle="tab" href="#new" style="display: none;"><i class="mdi mdi-card-plus mr-1"></i> Add New / Edit</a>
            </nav>

            <div id="mw-modules-tabs" class="tab-content py-3">
                <div class="js-list-testimonials tab-pane fade show active" id="list">
                    <div>
                        <a href="javascript:;" onclick="add_new_testimonial()" class="btn btn-primary btn-rounded mb-3"><i class="mdi mdi-plus"></i> &nbsp;<?php _e('New testimonial'); ?></a>
                    </div>

                    <module type="testimonials/list" id="list-testimonials"/>
                </div>

                <div class="tab-pane fade" id="settings">
                    <!-- Settings Content -->
                    <div class="module-live-edit-settings module-testimonials-settings">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Show testimonials for project'); ?></label>
                            <small class="text-muted d-block mb-2">If you have more than one template for testimonials, choose which one to be visible</small>
                            <module type="testimonials/project_select" id="project-select-testimonials" option-group="<?php print $params['id'] ?>"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php _e('Maximum number of testimonials to display'); ?></label>
                            <small class="text-muted d-block mb-2">Number of the visable testimonials </small>
                            <input type="text" class="form-control mw_option_field" name="testimonials_limit" value="<?php print $testimonials_limit; ?>"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php _e('Maximum number of characters to display'); ?></label>
                            <small class="text-muted d-block mb-2">Limit of the testimonial characters</small>
                            <input type="text" class="form-control mw_option_field" name="limit" value="<?php print $limit; ?>"/>
                        </div>
                    </div>
                    <!-- Settings Content - End -->
                </div>

                <div class="tab-pane fade" id="templates">
                    <module type="admin/modules/templates"/>
                </div>

                <div class="tab-pane fade" id="new">
                    <module type="testimonials/edit" id="edit-testimonials" edit-id="0"/>
                </div>
            </div>
        </div>
    </div>
</div>