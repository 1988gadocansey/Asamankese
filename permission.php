<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<!-- Filetree -->
	<script src="js/plugins/dynatree/jquery.dynatree.js"></script>
    <!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="span4">
									<h4>Filetree with checkboxes</h4>
									<div class="filetree filetree-checkboxes">
										<ul>
								            <li id="key1" title="Look, a tool tip!">item1 with key and tooltip</li>
								            <li id="key2" class="selected">item2: selected on init</li>
								            <li id="key3" class="folder">Folder with some children
								                <ul>
								                    <li id="key3.1">Sub-item 3.1</li>
								                    <li id="key3.2">Sub-item 3.2</li>
								                </ul>
											</li>
								            <li id="key4" class="expanded">Document with some children (expanded on init)
								                <ul>
								                    <li id="key4.1">Sub-item 4.1</li>
								                    <li id="key4.2">Sub-item 4.2</li>
								                </ul>
											</li>
								        </ul>
									</div>

</body>

</html>