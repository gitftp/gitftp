<div class="row">
    <div class="col-md-8">
        <div class="">
            <form class="form" action="">
                <?php if (isset($page)) { ?>
                    <input type="hidden" name="id" value="<?php echo $page['id']; ?>"/>
                <?php } ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" placeholder="Page title" name="title" value="<?php echo isset($page) ? $page['title'] : ''; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Slug</label>
                            <input type="text" class="form-control" placeholder="Page slug" name="slug" value="<?php echo isset($page) ? $page['slug'] : '' ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Page content</label>

                    <div id="summernote"><?php echo isset($page) ? $page['content'] : '' ?></div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <form class="form" action="">
            <div class="form-group">
                <label for="">Page type</label>
                <?php $type = isset($page) ? $page['type'] : '' ?>
                <select name="type" id="" class="form-control">
                    <option value="">Select page type</option>
                    <option value="documentation" <?php echo $type == 'documentation' ? 'selected' : '' ?>>Documentation</option>
                    <option value="getting-started" <?php echo $type == 'getting-started' ? 'selected' : '' ?>>Getting started</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Position</label>
                <input type="number" class="form-control" name="position" value="<?php echo isset($page) ? $page['position'] : '' ?>"/>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <?php
                        $published = isset($page) ? $page['published'] : NULL;
                        if(is_null($published)){
                            $published = 0;
                        }
                    ?>
                    <label for="pub">
                        <input id="pub" type="checkbox" value="1" name="published" <?php echo $published == '0' ? '' : 'checked'  ?> /> Published
                    </label>
                </div>
            </div>
        </form>

        <a href="#" class="btn btn-success submit"><?php echo isset($page) ? 'Update' : 'Save' ?> page</a>
    </div>
</div>
<style>
    .note-codable {
        display: none;
    }

    .codeview .note-codable {
        display: block;
    }

    .codeview .note-editable {
        display: none;
    }
</style>
<script>
    $(function () {
        $(window).bind('keydown', function (event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        $('a.submit').trigger('click');
                        break;
                    case 'f':
                        event.preventDefault();
                        alert('ctrl-f');
                        break;
                    case 'g':
                        event.preventDefault();
                        alert('ctrl-g');
                        break;
                }
            }
        });
        $('#summernote').summernote({
            fontNames: ["Roboto"],
            defaultFontName: 'Roboto',
            height: 400
        });
        $('form').submit(function (e) {
            return false;
        });
        $('.submit').on('click', function (e) {
            var btn = $(this);
            e.preventDefault();
            var data = $('form').serializeArray();
            data.push({
                name: 'content',
                value: $('#summernote').code()
            });
            console.log(JSON.stringify(data));
            btn.html('Saving..');
            $.ajax({
                url: '',
                data: data,
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                if (res.id !== 0) {
                    btn.html('Saved')
                        <?php if(!isset($page)) { ?>
                        .prop('disabled', true);
                    <?php } ?>
                }
            });
        })
    });
</script>