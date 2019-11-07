<?php
echo "<?xml version='1.0'?>";
?>
<rss version="2.0">
    <channel>
        <title>{name_lenta}</title>
        <link>{url}</link>
        <description>Блог noi.studio , заметки о коде,клиентах и верстальщиках. Мат 18+</description>

        <?php
        if (count($rows)) {
            foreach ($rows as $row) {
                $row['short'] = strip_tags($row["short"]);
                $row['short'] = filter_var($row["short"], FILTER_SANITIZE_STRING);
                ?>
                <item>
                    <title><?php echo $row["title"]; ?></title>
                    <image>{url_site}<?php echo $row["image"]; ?></image>
                    <link>{url_site_post}<?php echo $row["last_id"]; ?></link>
                    <description><?php echo strip_tags($row["short"]); ?></description>
                    <author>email@email.com</author>
                    <pubDate><?php echo date("D, d M Y H:i:s T", mg\MongoHelper::time($row["date"])); ?></pubDate>
                </item>
                <?php
            }
        }
        ?>



    </channel>
</rss>