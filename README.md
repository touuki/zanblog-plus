# ZanBlog Plus
ZanBlog Plus是基于ZanBlog 2.1.0的WordPress主题。由于原[ZanBlog](https://github.com/yeahzan/zanblog)主题长期无人维护，并且官网已经失效，所以本项目以ZanBlog 2.1.0为基础，基本保留原主题的外观样式，对其代码进行了完全重构，并添加一些新的特性，使之能够适用于最新版本的WordPress。相比ZanBlog 2.1.0的更改见[CHANGELOG.md](CHANGELOG.md)。  
演示站：[https://blog.touuki.com/](https://blog.touuki.com/)

## 安装方法
1. 在[release](https://github.com/touuki/zanblog-plus/releases)页面下载最新版本的`.zip`主题压缩包
2. 在`WordPress后台->外观`点击`添加`，之后点击`上传主题`，选择刚才下载的主题文件进行安装
3. 启用`ZanBlog Plus`主题，然后开始自定义吧

## 文档
### 功能
+ 可在菜单中添加fontawesome的图标，只需按照原始方法添加HTML标记即可，例如`<i class="fas fa-book"></i>`
+ 可在小工具标题中添加`i$class-name$`标记来添加fontawesome图标，比如`i$fas fa-book$`会在输出中自动替换成`<i class="fas fa-book"></i>`
+ 可在近期文章小工具标题中添加`i$random-posts$`使之变成随机文章
+ 可在小工具设置面板中选择在哪些页面上隐藏小工具
+ 可在自定义中设置背景图像以及网站Logo，没有Logo的情况下Logo位置显示站名及副标题，有Logo的情况下站名及副标题仅阅读器可见
+ 可在自定义`内容设置`中设置文章末尾的版权声明信息，可用变量有文章标题`%POST_TITLE%`、文章链接`%POST_URL%`、文章发布日期`%POST_DATE%`、文章发布时间`%POST_TIME%`、文章作者`%POST_AUTHOR%`、文章作者链接`%AUTHOR_URL%`、网站名称`%BLOG_NAME%`、网站链接`%BLOG_URL%`
+ 可在自定义`内容设置`中设置是否禁用文本转义，在中文环境下建议禁用转义，这样可以让后台输入的内容和前台显示一致
### 推荐插件
主题的正常工作不需要添加任何插件，但是下面这些插件会让主题更好哦
+ **WP-PostViews** 安装后可在文章元数据中显示文章浏览数，可使用经过样式适配的WP-PostViews小工具
+ **Breadcrumb NavXT** 安装后可自动在首页之外的页面上方显示面包屑导航
+ **Smush** 启用`lazyload`图片懒加载后更有利于页面的渲染，并且主题对图片尺寸进行了适配，不会产生懒加载的垂直跳跃问题
+ **WP Mail SMTP** 安装设置好SMTP后可使用评论回复通知功能

## TODO
+ 异步评论加载（使用WordPress REST API重构）
+ 登录页面、登录小工具
+ 文章存档页面
+ 更多自定义选项：导航栏搜索框隐藏、主题颜色、页脚内容
+ 支持多种文章格式显示
+ 经典编辑器样式适配
+ 小型设备下拉菜单添加展开按钮，目前移动端存在无法点击次级菜单的问题

## LICENSE
Copyright (c) 2020 Touuki, [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)