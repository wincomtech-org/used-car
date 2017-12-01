{__NOLAYOUT__}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>提示信息</title>
    <meta name="keywords" content="{$site_info.site_seo_keywords|default=''}"/>
    <meta name="description" content="{$site_info.site_seo_description|default=''}">

    <include file="public@head"/>
</head>
<body>
    <!-- 头部 -->
    <include file="public@header" />
    <!-- 导航 -->
    <include file="public@nav" />

    <!-- 合同 -->
    <section class="selection_insurance">
        <div class="main">
            <div class="selection_insurance_con">
                <div class="contact_sucess">
                    <p>
                    <?php switch($code): ?>
                        <?php case 1: ?>
                            <span class="icon"></span>
                            <p class="success"><?php echo(strip_tags($msg));?></p>
                        <?php break; ?>
                        <?php case 0: ?>
                            <span></span>
                            <p class="error"><?php echo(strip_tags($msg));?></p>
                        <?php break; ?>
                    <?php endswitch; ?>
                    页面自动 <a id="href" href="<?php echo($url);?>">跳转</a>
                    等待时间： <b id="wait"><?php echo($wait);?></b>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
    <!-- 底部 -->
    <include file="public@footer" />
    <include file="public@scripts" />
</body>
</html>