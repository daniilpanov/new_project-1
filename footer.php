	<div id="footer-container">
        <div class="row">
            <div class="col-md-3 footer">
                <div>
                    <p>©<?=date("Y")." ".SITE;?></p>
                    <p><?php echo FOOTER;?></p>
                </div>
            </div>

            <div class="col-md-5 footer">
                <div class="counter">
                    <?php require_once 'counters.php';?>
                </div>
            </div>

            <div class="col-md-4 development">
                <div class="logotext">
                    <?php echo DEVELOPMENT;?>&nbsp;<a href="http://www.clubintellect.ru"><img alt="" src="upload/images/site_development.png">&nbsp;<span style="color: #f39c12;"><?php echo DEVELOPMENTCOMPANY;?> </span></a>
                </div>
            </div>

    	</div>
	</div>
</div>
</body>
</html>