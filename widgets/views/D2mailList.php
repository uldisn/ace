<div class="tab-content no-border no-padding">
    <div class="tab-pane in active">
        <div class="message-container">
            <div class="message-navbar align-center clearfix" id="id-message-list-navbar">
                <div class="message-bar">
                    <div id="id-message-infobar" class="message-infobar">
                        <?php
                        if (isset($title_big)) {
                            ?>                                  
                            <span class="blue bigger-150"><?php echo $title_big ?></span>
                            <?php
                        }
                        if (isset($title_big)) {
                            ?>                                                                  
                            <span class="grey bigger-110"><?php echo $title_small ?></span>
                            <?php
                        }
                        ?>                                                                  
                    </div>

                </div>
                <div>
                    <div class="nav-search <?php echo empty($search) ? 'minimized' : ''; ?>">
                        <form class="form-search" id="messages_search_form" >
                            <span class="input-icon">
                                <input id="messages_search_input" type="text" placeholder="Search inbox ..." class="input-small nav-search-input" autocomplete="off" value="<?php echo $search; ?>">
                                <i class="icon-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div>
                </div>

            </div>
            <?php
            /**
             * message list
             */
            $mc = $messages_format['columns'];
            ?> 
            <div class="message-list-container">
                <div id="message-list" class="message-list">
                    <?php
                    foreach ($messages as $m) {
                        ?>
                        <div  data-internalid="<?php echo $m['id']; ?>" class="message-item<?php echo ($mc['unread'] && $m['unread']) ? ' message-unread' : ''; ?>">
                            <?php
                            //checkbox
                            if ($mc['checkbox']) {
                                ?>
                                <label class="inline">
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                                <?php
                            }

                            if ($mc['stared']) {
                                if ($m['stared']) {
                                    ?>
                                    <i class="message-star icon-star orange2"></i>
                                    <?php
                                } else {
                                    ?>
                                    <i class="message-star icon-star-empty light-grey"></i>
                                    <?php
                                }
                            }

                            if ($mc['sender']) {
                                ?>
                                <span class="sender">
                                    <span class="text">
                                        <?php echo $m['sender'] ?>
                                    </span>
                                </span>
                                <?php
                            }

                            if ($mc['time']) {
                                ?>
                                <span class="time"><?php echo $m['time'] ?></span>
                                <?php
                            }

                            if ($mc['attachment'] && isset($m['attachment']) && $m['attachment']
                            ) {
                                ?>
                                <span class="attachment">
                                    <i class="icon-paper-clip"></i>
                                </span>
                                <?php
                            }

                            if ($mc['model_name']) {
                                ?>
                                <span class="model_name">
                                    <span class="text">
                                        <?php echo Yii::t('models', $m['model_name']) ?>
                                    </span>
                                </span>
                                <?php
                            }

                            if ($mc['model_label']) {
                                ?>
                                <span class="model_label">
                                    <span class="text">
                                        <?php echo $m['model_label'] ?>
                                    </span>
                                </span>
                                <?php
                            }

                            if ($mc['subject']) {
                                ?>
                                <span class="subject">
                                    <span class="text">
                                        <?php echo $m['subject'] ?>
                                    </span>
                                </span>
                                <?php
                            }


                            if ($mc['summary']) {
                                ?>
                                <span class="summary">
                                    <?php
                                    if ($mc['message_flags'] && isset($m['message_flags'])) {
                                        ?>
                                        <span class="message-flags">
                                            <i class="<?php echo $m['message_flags'] ?>"></i>
                                        </span>
                                        <?php
                                    }
                                    if ($mc['badge'] && isset($m['badge'])) {
                                        ?>
                                        <span class="badge <?php echo $m['badge'] ?>"></span>
                                        <?php
                                    }
                                    ?>
                                    <span class="text">
                                        <?php echo $m['summary'] ?>
                                    </span>
                                </span>
                                <?php
                            }
                            ?>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div><!-- /.message-list-container -->

            <div class="message-footer clearfix">
                <div class="pull-left"> 
                    <?php
                    //echo $pages->itemCount
                    echo Yii::t('AceModule.d2maillist', '{n} messages total', array($pages->itemCount));
                    ?></div>
                <div class="pull-right">
                    <div class="inline middle"> 
                        <?php
                        echo Yii::t('AceModule.d2maillist', 'page {n}  of  {m}', array($pages->currentPage + 1, '{m}' => $pages->pageCount));
                        ?> 
                    </div>

                    &nbsp; &nbsp;
                    <ul class="pagination inline unstyled middle">
                        <?php
                        if ($pages->currentPage == 0) {
                            ?>
                            <li class="disabled">
                                <span>
                                    <i class="icon-step-backward middle"></i>
                                </span>
                            </li>

                            <li class="disabled">
                                <span>
                                    <i class="icon-caret-left bigger-140 middle"></i>
                                </span>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="page=1'; ?>">
                                    <i class="icon-step-backward middle"></i>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo 'page=' . ($pages->currentPage); ?>">
                                    <i class="icon-caret-left bigger-140 middle"></i>
                                </a>
                            </li>

                            <?php
                        }
                        if (false) {
                            ?>
                            <li>
                                <input type="text" maxlength="3" value="<?php echo $pages->currentPage + 1 ?>">
                            </li>
                            <?php
                        }
                        if ($pages->currentPage + 1 == $pages->pageCount) {
                            ?>
                            <li class="disabled">
                                <span>
                                    <i class="icon-caret-right bigger-140 middle"></i>
                                </span>
                            </li>

                            <li class="disabled">
                                <span>
                                    <i class="icon-step-forward middle"></i>
                                </span>
                            </li>

                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="<?php echo 'page=' . ($pages->currentPage + 2); ?>">
                                    <i class="icon-caret-right bigger-140 middle"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo 'page=' . $pages->pageCount; ?>">
                                    <i class="icon-step-forward middle"></i>
                                </a>
                            </li>
                            <?php
                        }
                        ?>                        
                    </ul>
                </div>
            </div>
        </div><!-- /.message-container -->
    </div><!-- /.tab-pane -->
</div><!-- /.tab-content -->

