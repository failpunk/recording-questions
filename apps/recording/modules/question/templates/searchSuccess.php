<?php use_helper('Search') ?>

<?php if(isset($pager)): ?>

<?php $res = $pager->getResults() ?>

    <?php if (!empty($res)): ?>
        <div class="related-question">

            <h4>Related Questions</h4>

            <ul>
                <?php foreach ($res as $item): ?>
                    <li><?php echo link_to($item->getTitle(), 'question/questionDetail?question_id='.$item->getId()) ?></li>
                <?php endforeach ?>
            </ul>

        </div>

        <p class="txt01">Will any of these existing questions answer yours?</p>

        <?php // set focus to tinymce editor after results ?>
        <script type="text/javascript">

            $().ready(function()
            {
                tinyMCE.activeEditor.focus();
            });

        </script>

    <?php endif ?>

<?php endif; ?>