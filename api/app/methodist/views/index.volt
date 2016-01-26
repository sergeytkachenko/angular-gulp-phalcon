<!DOCTYPE html>
<html>
	<head>
		 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>{{ title }}</title>
            <meta name="description" content="" />
            <meta name="keywords" content="" />

            <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
            <!--[if lt IE 9]> <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

            <script src="/js/jquery-1.11.2.min.js"></script>
            <script src="/js/jquery.validate.min.js"></script>
            <script src="/js/jquery.json.min.js"></script>
            <script src="/js/additional-methods.min.js"></script>
            <script src="/js/messages_uk.min.js"></script>

            <script src="/bootstrap/js/bootstrap.min.js"></script>

            <script src="/js/chosen/chosen.jquery.js"></script>
            <script src="/js/table-order.js"></script>
            <script src="/js/components.js"></script>
            <script src="/select2/js/select2.min.js"></script>
            <script src="/select2/js/i18n/select2_locale_uk.js"></script>

            <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="/bootstrap/css/bootstrap-responsive.min.css">
            <link rel="stylesheet" href="/font-awesome-4.3.0/css/font-awesome.min.css">

            <link rel="stylesheet" href="/js/chosen/chosen.css">
            <link rel="stylesheet" href="/select2/css/select2.css">
            <link rel="stylesheet" href="/select2/css/select2-bootstrap.css">

            <link rel="stylesheet" href="/css/default.css">
            <link rel="stylesheet" href="/css/ordering.css">
	</head>
	<body>
        <div class="page-header">
            <h1 align="center">{{ title }}</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <ul class="nav nav-tabs nav-stacked">
                        <li>
                            <a href="/methodist/student/" target="_top"><i class="fa fa-users"></i> {{trans._('students')}}</a>
                        </li>
                        <li>
                            <a href="/methodist/dealer/"><i class="fa fa-home"></i> {{trans._('dealers')}}</a>
                        </li>
                        <li>
                            <a href="/methodist/stafflist/posts"><i class="fa fa-suitcase"></i> {{trans._('posts')}}</a>
                        </li>
                        <li>
                            <a href="/methodist/stafflist/"><i class="fa fa-file-text"></i> {{trans._('staff_schedules')}}</a>
                        </li>
                        <li>
                            <a href="/methodist/stafflist/directionStudy"><i class="fa fa-graduation-cap"></i> {{trans._('educs_dir')}}</a>
                        </li>
                        <li>
                            <a href="/methodist/inspector/add"><i class="fa fa-user-plus"></i> {{trans._('add_controller')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="span10">
                    {{ content() }}
                </div>
            </div>
        </div>
	</body>
</html>