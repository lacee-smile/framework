body
{
	 font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
   width: 100%;
   position:absolute;
}

.indexDatas
{
  position: relative;
  margin-top: 2%;
  width: 50%;
  left: 25%;
}
.indexDatas > button
{
  font-size:60px;
	margin-top:25px;
}
#dataHolder
{
  position: relative;
  width:100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

#dataHolder > input
{
  height:75px;
  font-size: 60px;
  margin-top:35px;
}
.indexTitle
{
	font-size:75px;
	color:grey;
	text-align: center;
  margin-bottom:20px;
  margin-top:20px;
}

@media screen and (max-width: 980px)
{
	.indexDatas
	{
    position: static;
		width:98%;
		left:1%;
	}
}
.EndText
{
  position: relative;
  float: left;
  margin-top: 15px;
  height: 30px;
  width: 100%;
  transition: 0.5s linear;
  clear: left;
}
.form-control
{
	display:block;
	width:100%;
	height:35px;
	line-height:18px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    padding: 6px 12px;
    font-size:35px;
    margin-top:15px;
    color: #555;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form-control:focus
{
	border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
.btn
{
	display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 40px;
  font-weight: normal;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -ms-touch-action: manipulation;
      touch-action: manipulation;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  border: 1px solid transparent;
  border-radius: 4px;
  width:100%;
  color: #fff;
  background-color: #337ab7;
  border-color: #2e6da4;
}