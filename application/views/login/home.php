<!-- This is the home page, it has links to each of the things in the website -->

<?php 
    // Gear, Borrow and people links
    $heading_size="h2";
    $subheading_size="h4";
    echo ('<div class="row">');
    foreach($main_links as $link){
        // dbg($link);
        echo ('<div class="col-xs-4">');
            echo('<'.$heading_size.' style="text-align: center">');
                echo($link['title']);
            echo('</'.$heading_size.'>');
            
            //Print out the sublinks
            echo ('<div class="list-group">');
            foreach($link['link']['sub-links'] as $link_title => $sub_link){
                echo('<a href="../'.$sub_link['url'].'" class="list-group-item">
                    <'.$subheading_size.'>'.$link_title.'</'.$subheading_size.'>
                    </a>');
            }
            echo ('</div>');
        echo ('</div>');
    }
    echo ('</div>');

    // Items which are not the main items;
    echo ('<div class="list-group">');
    foreach($minor_links as $link){
        // dbg($link);
        echo('<a href="../'.$link['link']['url']['url'].'" class="list-group-item">
            <'.$subheading_size.'>'.$link['title'].'</'.$subheading_size.'>
            </a>');
    }
    echo ('</div>');
 ?>