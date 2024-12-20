<section id="footer" style="background-color: <?=$system_header_footer;?>;">
    <div class="container-ims">
        <div class="footer-part-control">
            <div class="part-letf">
                <h3 class="footer-title">អាសយដ្ឋាន</h3>
                <ul class="footer">
                    <li><a href=""><i class="fa fa-map-marker" aria-hidden="true"></i>ផ្លូវជាតិលេខ​​ ៤៤ ភូមិអូរអង្គុំ ឃុំអមលាំង ស្រុកថ្ពង ខេត្ត​កំពង់ស្ពឺ។</a></li>
                    <li><a href=""><i class="fa fa-phone" aria-hidden="true"></i>085 483 609 / 011 425 279 / 010 770 774/ 096 47 67 709</a></li>
                    <li><a href=""><i class="fa fa-envelope" aria-hidden="true"></i>info@ksit.edu.kh, bunhe@ksit.edu.kh</a></li>
                </ul>
            </div>
            <div class="part-letf part-right">
                <h3 class="footer-title">បណ្តាញសង្គម</h3>
                <ul class="footer">                          
                    <li><a href="https://www.facebook.com/KsitCambodia/"> <i class="fa fa-facebook-official" aria-hidden="true"></i>វិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ</a></li>
                    <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i>KsitCambodia</a></li>
                    <li><a href=""><i class="fa fa-twitter-square" aria-hidden="true"></i>KsitCambodia</a></li>
                    <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i>KsitCambodia</a></li>
                </ul>
            </div>
        </div>
        <p class="copy-right">
            រក្សាសិទ្ធគ្រប់យ៉ាងដោយ៖ វិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ | 2023
        </p>
    </div>
</section>

<!-- Modal Request letters -->
<div class="modal fade" id="request_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?=SITEURL;?>ims-student/request-letter.php" method="post" autocomplete="off">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Request letter</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="">Select letter <span class="text-danger">*</span></label>
                    <div class="d-flex">
                        <input type="checkbox" class="d-none" name="request-type[]" id="verify-study" value="លិខិតបញ្ជាក់ការសិក្សា"> <label for="verify-study" class="button verify_study">លិខិតបញ្ជាក់ការសិក្សា</label>
                    <input type="checkbox" class="d-none" name="request-type[]" id="transcript" value="ប្រតិបត្តិពិន្ទុ"> <label for="transcript" class="button transcript">ប្រតិបត្តិពិន្ទុ</label>
                    <input type="checkbox" class="d-none" name="request-type[]" id="certificate" value="សញ្ញាបត្របណ្តោះអាសន្ន"> <label for="certificate" class="button certificate">សញ្ញាបត្របណ្តោះអាសន្ន</label>

                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                     <a href="<?=SITEURL;?>ims-student/request-letter.php" class="d-block me-auto"><i class="fa fa-list pe-2" aria-hidden="true"></i> Your request</a>
                    <button type="submit" name="submit_request" value="submit_request" class="btn btn-primary btn-sm submit-request">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>