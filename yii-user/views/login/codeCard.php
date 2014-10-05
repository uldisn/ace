
	<body class="login-layout">
		<div class="main-container container-fluid">
			<div class="main-content">
				<div class="row-fluid">
					<div class="span12">
						<div class="login-container">
							<div class="row-fluid">
								<div class="center">
									<h1>
										<i class="icon-leaf green"></i>
										<span class="red"><?php echo Yii::app()->name;?></span>
									</h1>
								</div>
							</div>

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
                                            <div class="widget-main">
                                                <div style="position: absolute; top: 5px; right: 15px;"><h4><a style="text-decoration: none; color: #b94a48;" title="<?php echo UserModule::t("Logout"); ?>" href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>"><i class="icon-off"></i></a></h4></div>
												<h4 class="header blue lighter bigger">
													<i class="icon-lock green"></i>
													<?php echo UserModule::t("Enter the code from the code card"); ?>
												</h4>
                                                <?php
                                                if ($error) {
                                                    ?>
                                                    <div class="alert alert-danger"><i class="ace-icon fa fa-times"></i> <?php echo $error; ?></div>
                                                    <?php
                                                }
                                                
                                                if (!empty($reply['reply_type']) && $reply['reply_type'] == 'validate_code') {
                                                    
                                                    // Show code input form
                                                    $this->beginWidget(
                                                        'CActiveForm',
                                                        array(
                                                            'id'=>'code-card-form',

                                                        )
                                                    );
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="code" style="width: 100px; margin-top:5px; margin-bottom: 15px; float: left;" class="col-sm-3 control-label no-padding-right">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <?php echo UserModule::t("Code Nr.") . ' ' . $reply['add_data']; ?>
                                                        </label>

                                                        <div class="col-sm-9" style="float:left; margin-right: 5px;">
                                                            <input type="text" class="col-xs-10 col-sm-5 input-mini" style="height: 20px;" placeholder="<?php echo UserModule::t("Code"); ?>" id="code" name="code"/>
                                                        </div>
                                                        <?php  
                                                            $this->widget("bootstrap.widgets.TbButton", array(
                                                                "label"=>UserModule::t("OK"),
                                                                "icon"=>"fa-check icon-white",
                                                                "size"=>"small",
                                                                "type"=>"primary",
                                                                "htmlOptions"=> array(
                                                                    "onclick"=>"$('#code-card-form').submit();",
                                                                    "style" => "line-height:22px;",
                                                                ),
                                                            ));
                                                        ?>
                                                    </div>
                                                    <input type="hidden" name="session_id" value="<?php echo $reply['session_id']; ?>" />
                                                    <?php $this->endWidget(); ?>
                                                
                                                    <?php
                                                }
                                                ?>
											</div><!-- /widget-main -->

										</div><!-- /widget-body -->
									</div><!-- /login-box -->
								</div><!-- /position-relative -->
							</div>
						</div>
					</div><!-- /.span -->
				</div><!-- /.row-fluid -->
			</div>
		</div><!-- /.main-container -->
