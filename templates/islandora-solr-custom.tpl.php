<?php

/**
 * @file islandora-solr-custom.tpl.php
 * Islandora solr search results template
 *
 * Variables available:
 * - $variables: all array elements of $variables can be used as a variable. e.g. $base_url equals $variables['base_url']
 * - $base_url: The base url of the current website. eg: http://example.com .
 * - $user: The user object.
 *
 * - $style: the style of the display ('div' or 'table'). Set in admin page by default. Overridden by the query value: ?display=foo
 * - $results: the array containing the solr search results
 * - $table_rendered: If the display style is set to 'table', this will contain the rendered table.
 *    For theme overriding, see: theme_islandora_solr_custom_table()
 * - $switch_rendered: The rendered switch to toggle between display styles
 *    For theme overriding, see: theme_islandora_solr_custom_switch()
 *
 */
?>

<!--mods_title_ms ~ Title-->
<!--mods_topic_s ~ Topic-->
<!--mods_geographic_s ~ Location-->
<!--mods_publisher_s ~ Publisher-->
<!--mods_genre_s ~ Genre-->
<!--mods_subjectName_s ~ Subject-->
<!--mods_dateIssued_dt ~ Issued-->
<!--PID -> image-->

<?php print $switch_rendered; ?>

<?php if ($style == 'div'): ?>
<!-- 
  Basic layout:
  ol
    li (100%, some padding, border, alternating even/odd)
      div for thumbnail (fixed-width, vertically blocking, set minimum height with padding)
        img (thumbnail)
      div for rest (variable-width, height)
        foreach field (title (PAGE!?), creator):
        div (full width, fixed height?, borders)
        
  Total Field List:
    Title ~ mods_title_ms (: mods_subtitle_ms)
    Creator ~ mods_name_creator_ms
    Source Collection ~ mods_host_title_ms
    Type of Resource ~ mods_resource_type_ms
    Date ~ mods_dateOther_s
-->
<ol class="islandora_solr_results" start="<?php print $record_start; ?>">
  <?php if ($results == ''): print '<p>' . t('Your search yielded no results') . '</p>'; ?>
  <?php else: ?>
  <?php $z = 0; ?>
  <?php $zebra = 'even'; ?>
  <?php foreach ($results as $id => $result): ?>

    <?php
      // if no page thumbnail exists, use the parent (book cover) one
      $is_page = ( strpos( $result['rels_hasModel_uri_ms']['value'], 'pageCModel' ) !== false && !empty($result['rels_isMemberOfCollection_uri_ms']['value'] ) );
      $item_title = $result['mods_title_ms']['value'];
      $link_url = $base_url.'/fedora/repository/'.$result['PID']['value'].'/-/'.urlencode($item_title);
      $subtitle_value = ( empty( $result['mods_subTitle_ms']['value']) ? false : $result['mods_subTitle_ms']['value'] );
      $creator_value = ( empty( $result['mods_name_creator_ms']['value']) ? false : $result['mods_name_creator_ms']['value'] );
      $source_collection_value = ( empty( $result['mods_host_title_ms']['value']) ? false : $result['mods_host_title_ms']['value'] );
      $type_value = ( empty( $result['mods_resource_type_ms']['value']) ? false : $result['mods_resource_type_ms']['value'] );
      $date_value = ( empty( $result['mods_dateOther_s']['value']) ? false : $result['mods_dateOther_s']['value'] );
      $tn_url = $base_url."/fedora/repository/".$result['PID']['value']."/TN";
      $handle = @fopen($tn_url,'r');
      $thumbnail = '';
      if($handle !== false) {
        // gravy
        $thumbnail = '<img src="'.$tn_url.'" title="' . $result['mods_title_ms']['value'] . '" alt="' . $result['mods_title_ms']['value'] . '" />';
        fclose($handle);             
      } else {
        // look for, use, parent TN
        if( $is_page ) {
          $thumbnail = '<img src="'.$base_url.'/fedora/repository/' .
                       substr( $result['rels_isMemberOfCollection_uri_ms']['value'], strlen('info:fedora/') ) . 
                       '/TN" title="' . $result['mods_title_ms']['value'] . '" alt="' . $result['mods_title_ms']['value'] . '" />';
        } else {
          // finally, use "no image available"
          $thumbnail = '<img src="'.$base_url.'/'.drupal_get_path('theme','pittsburgh').'/images/not_available.png" alt="no image available" title="no image available"/>';
        }
      }
    ?>

    <?php $zebra = (($z % 2) ? 'odd' : 'even' ); ?>
    <?php $first = (($z == 0) ? ' first' : '' ); ?>
    <?php $last = (($z >= count($results)-1) ? ' last' : '' ); ?>
    <?php $z++;?>
    <li class="islandora_solr_result <?php print $zebra.$first.$last ?>">

      <div class="solr-left">
        <a href="<?php print $link_url; ?>">
          <?php print $thumbnail; ?>
        </a>
      </div>

      <div class="solr-right">

        <div class="solr-field <?php print $result['mods_title_ms']['class']; ?>">
          <!--div class="label"><label><?php print t($result['mods_title_ms']['label']); ?></label></div-->
          <div class="value">
            <a href="<?php print $link_url; ?>" title="<?php print $item_title; ?>">
              <?php print $item_title; ?>
              <?php if($subtitle_value): ?>
                <?php print ': '.$subtitle_value ?>
              <?php endif; ?>
            </a>
            <?php if(!empty($result['rels_isPageNumber_literal_ms']['value'])): ?>
              <span class="solr-page-number <?php print $result['rels_isPageNumber_literal_ms']['class']; ?>">p. <?php print $result['rels_isPageNumber_literal_ms']['value']; ?></span>
            <?php endif; ?>
          </div>
        </div>
        <?php if($creator_value): ?>
        <div class="solr-field <?php print $result['mods_name_creator_ms']['class']; ?>">
          <div class="value"><label><?php print t($result['mods_name_creator_ms']['label']); ?></label><?php print $creator_value; ?></div>
        </div>
        <?php endif; ?>
        <?php if($source_collection_value): ?>
        <div class="solr-field <?php print $result['mods_host_title_ms']['class']; ?>">
          <div class="value"><label><?php print t($result['mods_host_title_ms']['label']); ?></label><?php print $source_collection_value; ?></div>
        </div>
        <?php endif; ?>
        <?php if($type_value): ?>
        <div class="solr-field <?php print $result['mods_resource_type_ms']['class']; ?>">
          <div class="value"><label><?php print t($result['mods_resource_type_ms']['label']); ?></label><?php print $type_value; ?></div>
        </div>
        <?php endif; ?>
        <?php if($date_value): ?>
        <div class="solr-field <?php print $result['mods_dateOther_s']['class']; ?>">
          <div class="value"><label><?php print t($result['mods_dateOther_s']['label']); ?></label><?php print $date_value; ?></div>
        </div>
        <?php endif; ?>

      </div>
      <div class="solr-clear"></div>
    </li>
    <?php endforeach; ?>
  <?php endif; ?>
</ol>

<?php elseif ($style == 'table'): ?>

<?php print $table_rendered; ?>

<?php endif;
