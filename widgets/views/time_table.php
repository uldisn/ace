<?php
$col_count = count($header);
?>
<div id="calendar" class="fc fc-ltr">
    <table style="width:100%" class="fc-header">
        <tbody>
            <tr>
                <td class="fc-header-left">
                    <a  href="<? echo $urls['period_prev']; ?>"class="fc-button fc-button-prev fc-state-default fc-corner-left" unselectable="on" style="-moz-user-select: none;">
                        <i class="icon-chevron-left"></i>
                    </a>
                    <a href="<? echo $urls['period_next']; ?>" class="fc-button fc-button-next fc-state-default fc-corner-right" unselectable="on" style="-moz-user-select: none;">
                        <i class="icon-chevron-right"></i>
                    </a>
                    <span class="fc-header-space"></span>
                    <a href="<? echo $urls['period_today']; ?>" class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled" unselectable="on" style="-moz-user-select: none;">
                        <? echo $header_labels['period_today']; ?>
                    </a>
                </td>
                <td class="fc-header-center">
                    <span class="fc-header-title">
                        <h2><? echo $header_labels['title']; ?></h2>
                    </span>
                </td>
                <td class="fc-header-right">
                </td>
            </tr>
        </tbody>
    </table>
    <div class="fc-content" style="position: relative;">
        <div class="fc-view fc-view-month fc-grid" style="position: relative; -moz-user-select: none;" unselectable="on">
            <table class="fc-border-separate" cellspacing="0" style="width:100%">
                <thead>
                    <tr class="fc-first fc-last">
                        <?php
                        foreach ($header as $i => $label) {
                            $date = new DateTime($label);
                            $add_class = '';
                            if ($i == 0) {
                                $add_class = ' fc-first';
                            }
                            if ($i == $col_count - 1) {
                                $add_class = ' fc-last';
                            }
                            ?>
                            <th class="fc-day-header fc-widget-header<?php echo $add_class; ?>" style="width: 151px;">
                                <?php echo $date->format($date_format); ?>
                            </th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>   
                <tbody>
                    <?php
                    foreach ($this->body_data as $bk => $body_row) {
                        $add_class = '';
                        if ($bk == 0) {
                            $add_class = ' fc-first';
                        }
                        if ($bk == count($this->body_data) - 1) {
                            $add_class = ' fc-last';
                        }
                        ?>
                        <tr class="fc-week<?php echo $add_class; ?>">
                            <?php
                            $open = false;
                            for ($iTd = 0; $iTd < $col_count; $iTd++) {
                                $label = '';
                                $label_class = '';
                                $td_add_class = [];
                                if ($iTd == 0) {
                                    $td_add_class[] = 'fc-first';
                                }
                                if ($iTd == $col_count - 1) {
                                    $td_add_class[] = 'fc-last';
                                }
                                $colspan = '';
                                if ($body_row['start_date'] == $header[$iTd] || $open) {
                                    $label = '<a href="' . $body_row['url'] . '" class="btn btn-block btn-' . $body_row['color'] . '">
                                <i class="' . $body_row['icon'] . ' bigger-125"></i>
                            ' . $body_row['label'] . '</span>';
                                    $colspan = 1;
                                    while ($iTd < $col_count && $body_row['end_date'] != $header[$iTd]) {
                                        $iTd ++;
                                        $colspan ++;
                                    }
                                    $colspan = ' colspan="' . $colspan . '"';
                                }
                                ?>
                                <td<?php echo $colspan; ?> class="fc-day fc-sun fc-widget-content fc-other-month fc-past <?php echo implode(' ', $td_add_class); ?>" data-date="2014-12-28">
                                    <?php echo $label; ?>
                                </td>

                                <?php
                            }
                            ?>    


                        </tr>
                        <?php
                    }
                    ?>        
                </tbody>
            </table>
        </div>
    </div>
</div>    