<div class="inner-page-title">
        <h2>
            <?php
                if(!empty($title))
                {
                    echo $title;
                }
            ?>
        </h2>
    
        <span>
            <?php
                if(!empty($desc))
                {
                    echo $desc;
                }
            ?>
        </span>
</div>

<div class="content-box content-box-header">
    <div class="content-box-wrapper">
            <h3>
                <?php
                    if(!empty($subtitle))
                    {
                        echo $subtitle;
                    }
                ?>
            </h3>
            
            <p>
                <?php
                    if(!empty($msg))
                    {
                        echo $msg;
                    }
                ?>
            </p>
    </div>
</div>