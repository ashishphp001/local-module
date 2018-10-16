<aside id="sidebar_main" class="card">
    <div class="sidebar_main_header">
        <div class="user-info">
            <div class="image">
                <?php
                $imagename = $getUserData['varImage'];
                $imagepath = 'upimages/users/images/' . $imagename;

                if (file_exists($imagepath) && $getUserData['varImage'] != '') {
                    $image_thumb = image_thumb($imagepath, 200, 200);
                } else {
                    $image_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
                }
                ?>
                <img src="<?php echo $image_thumb; ?>" width="48" height="48" title="<?php echo $getUserData['varName']; ?>" alt="<?php echo $getUserData['varName']; ?>">
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $getUserData['varName']; ?></div>
                <div class="email"><?php echo $getUserData['varEmail']; ?></div>
            </div>
        </div>
    </div>
    <?php
    $Get_Dashboard_Url = $this->common_model->getUrl("pages", "2", "107", '');
    $Get_Product_Url = $this->common_model->getUrl("pages", "2", "110", '');
    if (RECORD_ID == '107') {
        $dashboardclass = "current_section";
        $productclass = "";
    } else if (RECORD_ID == '110') {
        $productclass = "current_section";
        $dashboardclass = "";
    } else {
        $productclass = "";
        $dashboardclass = "";
    }
    ?>
    <div class="menu_section">
        <ul>
            <li class="<?php echo $dashboardclass; ?>">
                <a href="javascript:;">
                    <i class="home"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">User Dashboard</span>
                </a> 
                <ul>
                    <li>
                        <a class="" href="<?php echo $Get_Dashboard_Url; ?>">
                            Dashboard
                        </a>
                    </li>
                </ul>              
            </li>
            <li class="<?php echo $productclass; ?>">
                <a href="javascript:;">
                    <i class="home"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">User Products</span>
                </a> 
                <ul>
                    <!--<li class=" act_item">-->
                    <li>
                        <a class="" href="<?php echo $Get_Product_Url; ?>">
                            All
                        </a>
                        <a class="" href="<?php echo $Get_Product_Url; ?>?type=a">
                            Approved
                        </a>
                        <a class="" href="<?php echo $Get_Product_Url; ?>?type=p">
                            Pending
                        </a>
                        <a class="" href="<?php echo $Get_Product_Url; ?>?type=r">
                            Rejected
                        </a>
                    </li>
                </ul>              
            </li>
            <li><a href=""><span class="menu_icon"><i class="material-icons">person</i></span><span class="menu_title">My Profile</span></a></li>
            <li class="">
                <a href="#">
                    <i class="view_list"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">My Inquiry</span>
                </a> 
                <ul>
                    <li class=" ">
                        <a class="" href="#">
                            Incoming
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            Outgoing
                        </a>
                    </li>          
                </ul>              
            </li>
            <li><a href=""><span class="menu_icon"><i class="fas fa-tags"></i></span><span class="menu_title">My sell Lead</span></a></li>
            <li><a href=""><span class="menu_icon"><i class="material-icons">favorite</i></span><span class="menu_title">My Favourite</span></a></li>
            <li><a href=""><span class="menu_icon"><i class="material-icons">business</i></span><span class="menu_title">Company Info</span></a></li>
            <li><a href=""><span class="menu_icon"><i class="material-icons">business</i></span><span class="menu_title">Banking Details</span></a></li>
            <li class="">
                <a href="#">
                    <i class="library_books"></i>
                    <span  class="menu_icon"><i class="fab fa-product-hunt"></i></span>
                    <span class="menu_title">Products </span>
                    <!--<i class="material-icons md-color-red-600">&#xE031;</i>-->  
                </a> 
            </li>
            <li class="">
                <a href="#">
                    <i class="library_books"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">  User Deshbord</span>
                    <!--<i class="material-icons md-color-red-600">&#xE031;</i>-->  
                </a> 
                <ul>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                    <li class=" ">
                        <a class="" href="#">
                            User Deshbord
                        </a>
                    </li>
                </ul>              
            </li>
            <li class="">
                <a href="#">
                    <i class="photo_librabry"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">  User Deshbord</span>
                    <!--<i class="material-icons md-color-red-600">&#xE031;</i>-->  
                </a> 
                <ul>
                    <li class="dropdown_parent ">
                        <a class="" href="#">
                            <b class="sub-arrow"></b>
                            User Deshbord
                        </a>
                    </li>
                </ul>              
            </li>
            <li class="">
                <a href="#">
                    <i class="pages"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">  User Deshbord</span>
                    <!--<i class="material-icons md-color-red-600">&#xE031;</i>-->  
                </a> 
                <ul>
                    <li class="dropdown_parent ">
                        <a class="" href="#">
                            <b class="sub-arrow"></b>
                            User Deshbord
                        </a>
                    </li>
                </ul>              
            </li>
            <li class="">
                <a href="#">
                    <i class="view_list"></i>
                    <span  class="menu_icon"><i class="material-icons">home</i></span>
                    <span class="menu_title">  User Deshbord</span>
                    <!--<i class="material-icons md-color-red-600">&#xE031;</i>-->  
                </a> 
                <ul>
                    <li class="dropdown_parent ">
                        <a class="" href="#">
                            <b class="sub-arrow"></b>
                            User Deshbord
                        </a>
                    </li>
                </ul>              
            </li>
        </ul>
    </div>
</aside>