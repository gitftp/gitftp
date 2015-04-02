<?php
echo View::forge('intro/search/header');
echo View::forge('intro/search/breadcumb');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-block">
                <div class="about-seller">
                    <span class="title">NRI</span>
                    <div class="space10"></div>
                    <p>NRIs can acquire any immovable property(other than agricultural land, plantation or farm-house property) by way of purchase, provided the payment is made out of foreign exchange inward remittance or any Non Resident bank account in India, i.e. Non Resident External Account - NR (E), Foreign currency Non Resident Account - FCNR or Non Resident Ordinary Account - NRO account. Although immovable property is not defined, the same will include: </p>
                    <ul>
                        <li>Residential property being house property, bungalow, apartment, villas and all other kinds of residential properties</li>
                        <li>Commercial property being shops, offices and show rooms</li>
                        <li>Industrial property being factory premises and godowns</li>
                        <li>Land for construction of any of the above properties, </li>
                    </ul>
                    <p>Acquisition can be made by way ofay:</p>
                    <ul>
                        <li>Purchase</li>
                        <li>Receiving the property as a gift</li>
                        <li>Inheritance, and</li>
                        <li>Share of joint property received upon partition of family or property.</li>
                    </ul>
                    <p>Transfer: Although transfer is not defined under the Regulations, but the definition of FEMA, 99 [Sec. 2(ze) of F.E.M.A. 1999] will apply & include:</p>
                    <ul>
                        <li>The acquisition should be in accordance with the existing Foreign Exchange Laws (i.e. FERA, '73 or FEMA '99).</li>
                        <li>The purchase price was met out of Foreign Exchange Inward Remittance or NRE / FCNR (B) account, and</li>
                        <li>In case of residential properties, repatriation is restricted to a maximum of two properties.</li>
                    </ul>
                    <p>The NRIs who are staying abroad may enter into an agreement through their relatives by executing the Power of Attorney in their favor if it is not possible for them to be present for completing the formalities of purchase (negotiating with the builder or developer, drafting and signing of agreements and taking possession). Rental income cannot be remitted abroad and will have to be credited to the ordinary non-resident rupee account of the owner of the property.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo View::forge('intro/search/footer');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>

<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/vendor/bootstrap.min.js"></script>
<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/main.js"></script>
<script src="<?php echo Uri::base(false); ?>assets/js/newsearch/jquery.flexslider-min.js"></script>
</body>
</html>
