<ul class="list related-questions">

    <?php if(isset ($title)): ?>
        <h3><?php echo $title ?></h3>
    <?php endif ?>

    <li>

        <?php if(!$questions): ?>

            <p>
                We didn't find any related questions,
                <?php echo link_to("Ask your own question", "@ask_question?question_tags=".$object->getTagName()) ?>
            </p>

        <?php else: ?>


        <?php echo include_component('question', 'questionList', array(
                                                            'questions' => $questions,
                                                            'display_compact' => true,
                                                            'base_route' => $base_route
                                    )) ?>
        <?php endif ?>

    </li>

</ul>
