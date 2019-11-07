
/*
Copyright 2017 Ziadin Givan

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

https://github.com/givanz/Vvvebjs
*/




<?php
$array_blocks = array();
if (count($all)) {
    foreach ($all as $block) {
        $array_blocks[] = "bootstrap4/block" . $block['id'];
    }
    ?>

    Vvveb.BlocksGroup['Bootstrap 4 Snippets'] = <?php echo json_encode($array_blocks); ?>;



    <?php
    foreach ($all as $block) {
        ?>
        Vvveb.Blocks.add("bootstrap4/block<?php echo $block['id']; ?>", {
        'id':"<?php echo $block['id']; ?>",
        name: "<?php echo $block['title']; ?>",
        dragHtml: '<img src="<?php echo $path_blockjpg; ?>">',
        image: "<?php echo $path_blockjpg; ?>",
        html: `
        <?php echo $block['html']; ?>
        `,
        });
        <?php
    }
}
?>























