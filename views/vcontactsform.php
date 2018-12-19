<div class="container-fluid">
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h3><u><?=FEEDBACK?></u></h3></legend>

            <p class="form-group">
                <label>
                    <?=PHONE?>*
                    <br>
                    <input class="form-control" type="text" name="phone" required />
                </label>
            </p>

            <p class="form-group">
                <label>
                    <?=EMAIL?>*
                    <br>
                    <input class="form-control" type="text" name="from" required />
                </label>
            </p>

            <p class="form-group">
                <label>
                    <?=SUBJECT?>
                    <br>
                    <input class="form-control" type="text" name="subject" />
                </label>
            </p>

            <p class="form-group">
                <label>
                    <?=MESSAGE?>
                    <br>
                    <textarea class="form-control" name="mess" rows="10" cols="45"></textarea>
                </label>
            </p>

            <p>
                <label>
                    <?=ATTACHFILE?>
                    <br>
                    <input class="form-control" type="file" name="attach[]" multiple />
                </label>
            </p>

            <p class="form-group">
                <button class="btn btn-danger" type="reset" name="reset"><?=CLEAR?></button>
                <button class="btn btn-success" type="submit" name="mail_submit"><?=SEND?></button>
            </p>

        </fieldset>
    </form>
</div>
