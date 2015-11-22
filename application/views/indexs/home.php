<div id="myCarousel" class="carousel slide" >
    <ol class="carousel-indicators" >

        <?php
            $i=0;
            foreach($slides as $slide)
            {
                echo "<li data-target='#myCarousel' data-slide-to='$i' class='active'></li>";
                $i++;
            }
        ?>
    </ol>
    <div class="carousel-inner">
        <?php
            $i=0;
            foreach($slides as $slide)
            {
                $title=$slide['slides_id'];
                $desc=$slide['slides_title'];
                $image=$slide['slides_image'];
                echo "<li data-target='#myCarousel' data-slide-to='$i' class='active'></li>";
                if($i==0)
                {
                    echo<<<_END
<div class="item active" >
            <img src="$image" alt="$title" class="img-responsive" >
            <div class="carousel-caption">
                <h3>$title</h3>
                <p>$desc</p>
            </div>
        </div>
_END;

                }
                else
                {
                    echo<<<_END
<div class="item" >
            <img src="$image" alt="$title" class="img-responsive" >
            <div class="carousel-caption">
                <h3>$title</h3>
                <p>$desc</p>
            </div>
        </div>
_END;

                }
                $i++;
            }
        ?>

    </div>
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>

</div>
<div id="social_site">
    <ul>
        <li id="facebook" class="transition"><a href="#" title="Facebook"><img class="social_icon transition" src="/public/images/facebook.png"></a></li>
        <li id="rss" class="transition"><a href="#" title="Rss"></a></li>
        <li id="youtube" class="transition"><a href="#" title="Youtube"></a></li>
        <li id="twitter" class="transition"><a href="#" title="Twitter"></a></li>
        <!-- <li id="donate" class="transition"><a href="#" title="Donate"><img class="social_icon transition" src="images/donate3.png"></a></li>-->
    </ul>


</div>
<div id="nav">
    <img src="/public/images/logo2.png">
    <ul>
        <li><a href="/" class="transition selected">Home</a></li>
        <li><a href="#info" class="transition">About</a></li>
        <li><a href="#prog" class="transition">Program</a></li>
        <li><a href="#" class="transition">Services</a></li>
        <li><a href="#" class="transition">Blog</a></li>
        <li><a href="/contacts/index" class="transition">Contact</a></li>
        <li><a href="#" class="transition">Donate</a></li>
    </ul>



</div>

<div id="info" class="transition">
    <div id="info1" class="sub transition">
        <h2>What we do..</h2>
        <p>In today’s times, there is an abundance of government schemes & programs for the people of India, but poor communication channel and numerous systemic ailments do not let the benefits reach the deserving people. The result is that people continue to languish and suffer despite the presence of so many solutions and much support from government. It’s a common reality in the villages of Bihar where people are either unaware or deprived of their fundamental. At Seva Setu, we are determined to change this state of despair, deprivation and exploitation and bring a tectonic change in the way social problems are solved. True to our name, we aim to serve as an enabler, facilitator and advocate and thus, bridge the gap between the provider (state/central government/concerned NGOs) of solutions and the targeted beneficiary (poor and needy people). Through our various programs and services we wish to provide last mile connectivity to people with the local state machinery in the full chain of transfer of benefits from the government to beneficiaries.</p>
    </div>


</div>

<div id="prog">
    <a href="#"> <div id="prghead" class="transition"><p class="transition"> PROGRAMS</p></div></a>
    <ul class="ch-grid">
        <li>
            <div class="ch-item ch-img-1">
                <div class="ch-info">

                    <h3>Mother Care</h3>
                    <p>by SevaSetu <a href="/programs/view/mother">Learn More...</a></p>
                </div>
            </div>
            <span>Mother Care</span>
        </li>
        <li>
            <div class="ch-item ch-img-2">
                <div class="ch-info">
                    <h3>Kids Care</h3>
                    <p>by SevaSetu <a href="#">Learn More...</a></p>
                </div>
            </div>
            <span>Kids Care</span>
        </li>
        <li>
            <div class="ch-item ch-img-3">
                <div class="ch-info">
                    <h3>Citizen Care</h3>
                    <p>by SevaSetu <a href="#">Learn More...</a></p>
                </div>
            </div>
            <span>Citizen Care</span>
        </li>
        <li>
            <div class="ch-item ch-img-4">
                <div class="ch-info">
                    <h3>AutoAid</h3>
                    <p>by SevaSetu <a href="#">Learn More...</a></p>
                </div>
            </div>
            <span>Auto Aid</span>
        </li>
        <li>
            <div class="ch-item ch-img-5">
                <div class="ch-info">
                    <h3>Sattu Making</h3>
                    <p>by SevaSetu <a href="#">Learn More...</a></p>
                </div>
            </div>
            <span>Sattu Making</span>
        </li>
    </ul>

</div>

<div id="info2" class="sub transition">
    <h2>Our Approach</h2>
    <p>We have observed that there is no dearth of resources or solutions in our society, but they are scattered and not reaching to the right people. So not getting trapped in re-inventing the wheel, we have aimed at bringing those existing solutions and resources to their targeted beneficiaries by acting as a bridge. We have innovated various programs and services that provide either the missing link in the delivery chain or the support to existing infrastructure. We believe in a problem solving society where people join hands  to solve any problem of any community. We see that if given proper support and assistance, local people can themselves solve their problems and hence we intend to create a network of volunteers, working professionals and advisors who can remotely support communities to solve their problems at local level.</p>
</div>

<div id="stat" class="sub">
    <ul class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 stat-container" id="stat1" data-counter="10">
            <div class="stat-count"></div>
            <div class="stat-title">Programs Launched</div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 stat-container" id="stat2" data-counter="200">
            <div class="stat-count"></div>
            <div class="stat-title">People Helped</div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 stat-container" id="stat3" data-counter="13">
            <div class="stat-count"></div>
            <div class="stat-title">Associations</div>
        </div>
    </ul>
</div>


<div id="carousel-example" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="row">
        <div class="col-xs-offset-3 col-xs-6">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="carousel-content">
                        <div>
                            <a href="#"><h3>#1</h3>
                                <p>This is a twitter bootstrap carousel that only uses text. There are no images in the carousel slides.</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="carousel-content">
                        <div>
                            <a href="#"><h3>#2</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, sint fuga temporibus nam saepe delectus expedita vitae magnam necessitatibus dolores tempore consequatur dicta cumque repellendus eligendi ducimus placeat! Sapiente, ducimus, voluptas, mollitia voluptatibus nemo explicabo sit blanditiis laborum dolore illum fuga veniam quae expedita libero accusamus quas harum ex numquam necessitatibus provident deleniti tenetur iusto officiis recusandae corporis culpa quaerat?</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="carousel-content">
                        <div>
                            <a href="#"><h3>#3</h3>
                                <p>This is the third item.</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Controls --> <a class="left carousel-control" href="#carousel-example" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>

</div>
<div id="info3" class="sub transition">
    <h2>How can you contribute..</h2>
    <p>We all have unique potential, abilities and resources with which we shape our future. At Seva Setu, we believe that by sharing these potential, abilities and resources with others, we can shape the future of society as well.  Come forward and share yours! Join us in our journey by contributing in whatever capacity you can and want to – intern, volunteer, investor, or a full time member. See the Get Involved section for specific requirements or contact us for anything that you want to discuss or explore. We would love to hear from you, and so do the many people whose lives you may touch by your this decision. Expand yourself by sharing what you have.</p>
</div>
