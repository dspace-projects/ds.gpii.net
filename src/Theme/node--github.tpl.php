<?php //dpm($node, "Node"); ?>
<?php //dpm($content, "Content"); ?>
<h2><?php print $name; ?></h2>
<div class="node node-hardware-component-listing node-promoted view-mode-full" role="article">
  <div class="row">
    <article class="col-sm-18 ">
      <div class="field field-name-body field-type-text-with-summary field-label-hidden">
        <div class="field-items">
          <div class="field-item even" property="content:encoded">
            <?php print $readme; ?>
          </div>
        </div>
      </div>
      <div class="field field-name-field-read-more field-type-link-field field-label-inline clearfix">
        <div class="field-label">Read more:&nbsp;</div>
        <div class="field-items">
          <div class="field-item even"><a href="<?php print $url; ?>"><?php print $url; ?></a>
          </div>
        </div>
      </div>
    </article>
    <aside class="col-sm-6 ">
      <h3 class="label-above">License</h3>
      <ul>
        <li><?php print $license; ?></li>
      </ul>
      <h3 class="label-above">Component Category</h3>
      <p>
        <?php
        $length = count($topics);
        foreach($topics as $index => $topic) {
          print $topic->name;
          if ($index != $length - 1) {
            print ", ";
          }
        }
        ?>
      </p>
      <h3 class="label-above">Metrics</h3>
      <ul>
        <li>Starred: <?php print $stargazers ?></li>
        <li>Watched: <?php print $watchers ?></li>
        <li>Forked: <?php print $forks ?></li>
      </ul>
      <h3 class="label-above">Contact</h3>
      <a href="<?php print $url; ?>"><?php print $url; ?></a>
    </aside>
  </div>
</div>


