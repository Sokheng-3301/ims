<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export transcript</title>
    
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&family=Poppins&display=swap");
        *{
            font-family: "Times New Roman", "Noto Sans Khmer", sans-serif;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            text-decoration: none;
            transition: all 0.2s;
            color: #003666;
            border-collapse: collapse;
        }
        .container{
            padding: 2%;
            display: block;
            margin: 0 auto;
            width: 100%;
        }
        
        .top{
            text-align: center;
        }
        .top h1{
            font-size: 100%;
        }
        .top h2{
            font-size: 90%;
        }
        img.tacteing{
            width: 5%;
        }
        .logo-top{
            margin-top: -2%;
            width: fit-content;
        }
        .logo-top .center{
            width: 33%;
            font-weight: bold;
        }
        .logo-top img{
            width: 22%;
            display: block;
            margin: auto;
            margin-left: 25%;
        }
        .logo-top .line{
            width: 80%;
            display: inline-block;
        }


        .logo-top .line p.left{
            float: left;
        }
        .logo-top  .line p.right{
            float: right;
        }

        .clear{
            float: unset;
            clear: both;
        }

        .content{
            margin-top: 20px;
        }
        .content h2{
            text-transform: uppercase;
            text-align: center;
            font-size: 90%;
            margin-bottom: 1%;
        }

        .content .d-flex{
            /* display: flex;
            justify-content: space-between; */
            margin-bottom: 1%;
        }

        .content .d-flex .part-left{
            width: 40%;
            float: left;
        }
        .content .d-flex .part-right{
            width: 40%;
            float: right;
        }


        .content .d-flex .part-right p span.title,
        .content .d-flex .part-left p span.title
        {
            width: 35%;
            display: inline-block;
        }
        .content .d-flex .part-right p span.value,
        .content .d-flex .part-left p span.value{
            display: inline-block;
            margin-left: 5%;
        }






        .content .section{
            width: 50%;
            float: left;
        }
        .content .section table{
            width: 100%;
            border: 1px solid #003666;
        }
        .content .section table th,
        .content .section table td{
            padding:0.5% 1%;
            text-align: start;
        }
        .content .section table thead th{
            border-bottom: 1px solid #003666;            
        }
        .content .section table td.title{
            font-size: 100%;
            font-weight: bold;
            text-decoration: underline;
            padding: 1% 3%;
        }
        .content .section table td.text-center{
            text-align: center;
        }


        .content .table-bottom{
            width: 40%;
            float: left;
            margin-top: 1%;

        }
        .content .table-bottom table{
            width: 100%;
            text-align: start;
            border: 1px solid #003666;

        }
        .content .table-bottom table th,
        .content .table-bottom table td{
            text-align: start;
            padding: 0.5% 1%;
            border: 1px solid #003666;
        }
        .content .table-bottom table th.text-center{
            text-align: center;
        }
        .text-center{
            text-align: center;
        }
        .content .table-bottom table td.text-center{
            text-align: center;
        }
        .content .table-bottom table td span{
            padding: 0 1.5%;
        }
        .content .table-bottom table td{
            border: unset;
            border-right:  1px solid #003666;
        }
        .content .sign-right{
            margin-top: 1%;
            width: 60%;
            height: auto;
            text-align: center;
            float: right;
        }
        .content .sign-right p.director{
            font-weight: bold;
        }
        .content .sign-right p.signature{
            margin-top: 8%;
            /* text-align: end; */
            font-weight: bold;
            margin-left: 20%;
        }
        footer{
            border-top: 2px solid #003666;
            width: 100%;
            margin-top: 2%;
            padding: 1% 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <h1>Kingdom of Cambodia</h1>
            <h2>Nation Relegion King</h2>
            <p><img src="ims-assets/ims-images/tacteing.png" class="tacteing" alt=""></p>
        </div>
        <div class="logo-top">
           <div class="center">
                <p><img src="ims-assets/ims-images/KSIT-LOGO.png" alt=""></p>
                <p>Kampong Speu Institute of Technology</p>
                <div class="line">
                    <p class="left">No.</p> <p class="right">KSIT</p></p>    
                    
                </div>
                <div class="clear"></div>  
            </div>     
        </div>
        <div class="content">
            <h2>Official academic transcript</h2>
            <div class="d-flex">
                <div class="part-left">
                    <p><span class="title">Name</span> <span>:</span> <span class="value">Voeurn Sokheng</span></p>
                    <p><span class="title">Student ID</span> <span>:</span> <span class="value">223108007</span></p>
                    <p><span class="title">Nationality</span> <span>:</span> <span class="value">Khmer</span></p>
                    <p><span class="title">Date of Birth  </span> <span>:</span> <span class="value">12-July-2002</span></p>
                    <p><span class="title">Place of Birth  </span> <span>:</span> <span class="value">Kampong Speu Province</span></p>
                </div>
                <div class="part-right">
                    <p><span class="title">Department</span> <span>:</span> <span class="value">Computer Science</span></p>
                    <p><span class="title">Degree</span> <span>:</span> <span class="value">Associate in Computer Technology </span></p>
                    <p><span class="title">Major subject</span> <span>:</span> <span class="value">Computer Technology</span></p>
                    <p><span class="title">Date of Admission  </span> <span>:</span> <span class="value"></span></p>
                    <p><span class="title">Date of Graduation  </span> <span>:</span> <span class="value"></span></p>
                </div>
                <div class="clear"></div>
            </div>
           
            <div class="section">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Credit</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tr class="title">
                        <td class="title">First year</td>
                        <td class="title" colspan="3">1st Semester</td>
                    </tr>

                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title text-center">Grade Point Average</td>
                        <td colspan="2" class="title text-center">2.79</td>
                    </tr>

                    <!-- #################################################################### -->

                    <tr>
                        <td class="title">First year</td>
                        <td class="title" colspan="3">2nd Semester</td>
                    </tr>

                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title text-center">Grade Point Average</td>
                        <td colspan="2" class="title text-center">2.79</td>
                    </tr>

                </table>    
            </div>


            <div class="section">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Credit</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tr class="title">
                        <td class="title">Second year</td>
                        <td class="title" colspan="3">1st Semester</td>
                    </tr>

                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title text-center">Grade Point Average</td>
                        <td colspan="2" class="title text-center">2.79</td>
                    </tr>

                    <!-- #################################################################### -->

                    <tr>
                        <td class="title">Second year</td>
                        <td class="title" colspan="3">2nd Semester</td>
                    </tr>

                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr> <tr>
                        <td>GM001</td>
                        <td>Subject name</td>
                        <td>2</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title text-center">Grade Point Average</td>
                        <td colspan="2" class="title text-center">2.79</td>
                    </tr>

                </table>    
            </div>

            <div class="clear"></div>
           
            <div class="table-bottom">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">Grade</th>
                            <th colspan="2" class="text-center">Mention</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">A+</td>
                            <td><span>4.0</span> <span>85-100</span> <span>Excellent</span></td>
                            <td>S = </td>
                        </tr>
                        <tr>
                            <td class="text-center">A+</td>
                            <td><span>4.0</span> <span>85-100</span> <span>Excellent</span></td>
                            <td>S = </td>
                        </tr>
                        <tr>
                            <td class="text-center">A+</td>
                            <td><span>4.0</span> <span>85-100</span> <span>Excellent</span></td>
                            <td>S = </td>
                        </tr>
                        <tr>
                            <td class="text-center">A+</td>
                            <td><span>4.0</span> <span>85-100</span> <span>Excellent</span></td>
                            <td>S = </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="sign-right">
                <p>Kampong Spue, 24-June-2024</p>
                <p class="director">Director</p>
                <p class="signature">HONG Kimcheang,PhD</p>
            </div>
            <div class="clear"></div>
        </div> 
        <footer>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, non quam sit explicabo corporis esse molestiae earum dolorum accusamus voluptate.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, soluta.</p>
        </footer>
    </div>
    
</body>
</html>