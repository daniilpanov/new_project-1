<div class="container-fluid">
    <form method="post">
        <fieldset id="review_form" class="form-group">
            <legend><h3><u><?=REVIEWADD?></u></h3></legend>

            <p id="reviewStars-input">
                <b><?=REVIEWRATE?></b><br>
                <input id="star-4" type="radio" value="5" name="rating"/>
                <label title="" for="star-4"></label>

                <input id="star-3" type="radio" value="4" name="rating"/>
                <label title="" for="star-3"></label>

                <input id="star-2" type="radio" value="3" name="rating"/>
                <label title="" for="star-2"></label>

                <input id="star-1" type="radio" value="2" name="rating"/>
                <label title="" for="star-1"></label>

                <input id="star-0" type="radio" value="1" name="rating"/>
                <label title="" for="star-0"></label>
            </p>

            <hr>

            <br /> <br />
            <br /> <br />

            <!--Скрытый input-->
            <p>
                <input type="hidden" name="page_id" value="<?php echo $_GET['id'];?>">
            </p>

            <p class="form-group">
                <label>
                    <?=REVIEWNAME?>
                    <br>
                    <input class="form-control" type="text" name="name" placeholder="<?=REVIEWNAMEINPUT?>">
                </label>
            </p>
            <p class="form-group">
                <label>
                    <?=REVIEW?>
                    <br>
                    <textarea class="form-control" rows="10" cols="45" name="review" placeholder="<?=REVIEWINPUT?>" required></textarea>
                </label>
            </p>
            <p class="form-group">
                <label>
                    <?=REVIEWUSERNAME?>
                    <br>
                    <input class="form-control" type="text" name="autor" placeholder="<?=REVIEWUSERNAMEINPUT?>" required>
                </label>
            </p>
            <p>
                <label class="form-group">
                    <?=REVIEWUSEREMAIL?>
                    <br>
                    <input class="form-control" type="text" name="email" placeholder="<?=REVIEWUSEREMAILINPUT?>" required>
                </label>
            </p>

            <p><input type="hidden" name="phone" placeholder="" class="phone"></p>
            <p><button type="submit" class="btn btn-primary" name="review_submit"><?=REVIEWBUTTON?></button></p>
        </fieldset>
    </form>
</div>