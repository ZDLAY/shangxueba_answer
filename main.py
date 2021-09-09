# * 上学吧链接获取答案API接口
# * 1.0版本只能通过链接获取
# * 获取方式：REQUEST
# -  提交参数：url,
# 
# class
# -  参数说明：url为上学吧链接
# -  class为输出结果参数，设置为kyz则直接输出答案
# * 请定时更新cookie值
# @author 中国DLAY
# @email zsxianoo@qq.com

# coding:utf-8
import wx
import requests

# 定义服务器地址
url = 'http://121.196.220.53/'

# 定义API
api = url + 'question.php'

# 定义dy题库api
dyapi = url + '?action=question-bank&class=search'

def get_dyanswer(event):
    get_question = path_text.GetValue()
    # 定义参数
    data = {'question': get_question}

    # 请求服务器
    rs = requests.get(dyapi, params=data)

    # 判断
    if rs.status_code == 200:
        content_text.SetValue(rs.text)
    else:
        content_text.SetValue('请求异常！')

def get_answer(event):  # 定义获取答案事件
    get_url = path_text.GetValue()
    # 定义参数
    data = {'url': get_url, 'class': 'kyz'}

    # 请求服务器
    rs = requests.get(api, params=data)

    # 判断
    if rs.status_code == 200:
        content_text.SetValue(rs.text)
    else:
        content_text.SetValue('请求异常！')


app = wx.App()
#icon_frame = wx.Frame(N
# one, wx.ID_ANY, u"带有图标的窗口")
icon = wx.Icon(name=".\\icon.ico", type=wx.BITMAP_TYPE_ICO)
frame = wx.Frame(None, title="上学吧链接获取答案", pos=(1000, 200), size=(500, 400))
frame.SetIcon(icon)

panel = wx.Panel(frame)

path_text = wx.TextCtrl(panel)
open_button = wx.Button(panel, label="获取答案")
open_button.Bind(wx.EVT_BUTTON, get_answer)  # 绑定打开文件事件到open_button按钮上

save_button = wx.Button(panel, label="DY题库")
save_button.Bind(wx.EVT_BUTTON, get_dyanswer)  # 绑定打开文件事件到open_button按钮上

content_text = wx.TextCtrl(panel, style=wx.TE_MULTILINE)
#  wx.TE_MULTILINE可以实现以滚动条方式多行显示文本,若不加此功能文本文档显示为一行

box = wx.BoxSizer()  # 不带参数表示默认实例化一个水平尺寸器
box.Add(path_text, proportion=5, flag=wx.EXPAND | wx.ALL, border=3)  # 添加组件
# proportion：相对比例
# flag：填充的样式和方向,wx.EXPAND为完整填充，wx.ALL为填充的方向
# border：边框
box.Add(open_button, proportion=2, flag=wx.EXPAND | wx.ALL, border=3)  # 添加组件
box.Add(save_button, proportion=2, flag=wx.EXPAND | wx.ALL, border=3)  # 添加组件

v_box = wx.BoxSizer(wx.VERTICAL)  # wx.VERTICAL参数表示实例化一个垂直尺寸器
v_box.Add(box, proportion=1, flag=wx.EXPAND | wx.ALL, border=3)  # 添加组件
v_box.Add(content_text, proportion=5, flag=wx.EXPAND | wx.ALL, border=3)  # 添加组件

panel.SetSizer(v_box)  # 设置主尺寸器

frame.Show()
app.MainLoop()
