<style type="text/css">
    thead tr {background-color: ActiveCaption; color: CaptionText;}
    th, td {vertical-align: middle; font-family: "Tahoma", Arial, Helvetica, sans-serif; font-size: 8pt; padding: 3px; }
    table, td {border: 1px solid silver;}
    table {border-collapse: collapse;}
    td{text-align: center}
</style>

<div id="content">
<table style="width: 100%">
    <thead>
        <tr>
            <th >#</th>
            <th > ﻋﻨﺎﺻﺮ ﺍﻟﺘﻘﺮﻳﺮ</th>
            <th > ﺍﻋﺪﺍﺩ ﺍﻟﻴﻮﻡ</th>
            <th >ﺍﻋﺪﺍﺩ ﺃﻣﺲ</th>
            <th colspan="4" >ﻧﺴﺒﺔ ﺍﻟﺘﻘﺪم</th>
            <th >ﻣﻼﺣﻈﺎﺕ</th>
        </tr>
        <tr>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th >90% </th>
            <th >70% </th>
            <th >50% </th>
            <th >اقل </th>
            <th ></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>عدد المستخدمين</td>
            <td>{{@$report[0]['all_users']}}</td>
            <td>{{@$report[1]['all_users']}}</td>
            <td>{{@$report[0]['all_users'] >= 90 ? @$report[0]['all_users'] . "%" : "" }}</td>
            <td>{{@$report[1]['all_users'] >= 70 && @$report[1]['all_users'] < 90  ? @$report[1]['all_users'] . "%": "" }}</td>
            <td>{{@$report[0]['all_users'] >= 50 && @$report[0]['all_users'] < 70  ? @$report[0]['all_users'] . "%": "" }}</td>
            <td>{{@$report[1]['all_users'] < 50  ? @$report[1]['all_users'] . "%": "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td>عدد مزودي الخدمة</td>
            <td>{{@$report[0]['providers']}}</td>
            <td>{{@$report[1]['providers']}}</td>
            <td>{{@$report[0]['providers'] >= 90 ? @$report[0]['providers']. "%" : "" }}</td>
            <td>{{@$report[1]['providers'] >= 70 && @$report[1]['providers'] < 90  ? @$report[1]['providers']. "%" : "" }}</td>
            <td>{{@$report[0]['providers'] >= 50 && @$report[0]['providers'] < 70  ? @$report[0]['providers']. "%" : "" }}</td>
            <td>{{@$report[1]['providers'] < 50  ? @$report[1]['providers']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td>عدد المنتجات</td>
            <td>{{@$report[0]['all_products']}}</td>
            <td>{{@$report[1]['all_products']}}</td>
            <td>{{@$report[0]['all_products'] >= 90 ? @$report[0]['all_products']. "%" : "" }}</td>
            <td>{{@$report[1]['all_products'] >= 70 && @$report[1]['all_products'] < 90  ? @$report[1]['all_products']. "%" : "" }}</td>
            <td>{{@$report[0]['all_products'] >= 50 && @$report[0]['all_products'] < 70  ? @$report[0]['all_products']. "%" : "" }}</td>
            <td>{{@$report[1]['all_products'] < 50  ? @$report[1]['all_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>4</td>
            <td>المنتجات قيد التفعيل</td>
            <td>{{@$report[0]['waiting_products']}}</td>
            <td>{{@$report[1]['waiting_products']}}</td>
            <td>{{@$report[0]['waiting_products'] >= 90 ? @$report[0]['waiting_products']. "%" : "" }}</td>
            <td>{{@$report[1]['waiting_products'] >= 70 && @$report[1]['waiting_products'] < 90  ? @$report[1]['waiting_products']. "%" : "" }}</td>
            <td>{{@$report[0]['waiting_products'] >= 50 && @$report[0]['waiting_products'] < 70  ? @$report[0]['waiting_products']. "%" : "" }}</td>
            <td>{{@$report[1]['waiting_products'] < 50  ? @$report[1]['waiting_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>5</td>
            <td>المنتجات المفعله</td>
            <td>{{@$report[0]['active_products']}}</td>
            <td>{{@$report[1]['active_products']}}</td>
            <td>{{@$report[0]['active_products'] >= 90 ? @$report[0]['active_products']. "%" : "" }}</td>
            <td>{{@$report[1]['active_products'] >= 70 && @$report[1]['active_products'] < 90  ? @$report[1]['active_products']. "%" : "" }}</td>
            <td>{{@$report[0]['active_products'] >= 50 && @$report[0]['active_products'] < 70  ? @$report[0]['active_products']. "%" : "" }}</td>
            <td>{{@$report[1]['active_products'] < 50  ? @$report[1]['active_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>6</td>
            <td>المنتجات الموقوفة</td>
            <td>{{@$report[0]['deactivated_products']}}</td>
            <td>{{@$report[1]['deactivated_products']}}</td>
            <td>{{@$report[0]['deactivated_products'] >= 90 ? @$report[0]['deactivated_products']. "%" : "" }}</td>
            <td>{{@$report[1]['deactivated_products'] >= 70 && @$report[1]['deactivated_products'] < 90  ? @$report[1]['deactivated_products'] . "%": "" }}</td>
            <td>{{@$report[0]['deactivated_products'] >= 50 && @$report[0]['deactivated_products'] < 70  ? @$report[0]['deactivated_products']. "%" : "" }}</td>
            <td>{{@$report[1]['deactivated_products'] < 50  ? @$report[1]['deactivated_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>7</td>
            <td>عدد الطلبات</td>
            <td>{{@$report[0]['all_orders']}}</td>
            <td>{{@$report[1]['all_orders']}}</td>
            <td>{{@$report[0]['all_orders'] >= 90 ? @$report[0]['all_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['all_orders'] >= 70 && @$report[1]['all_orders'] < 90  ? @$report[1]['all_orders']. "%" : "" }}</td>
            <td>{{@$report[0]['all_orders'] >= 50 && @$report[0]['all_orders'] < 70  ? @$report[0]['all_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['all_orders'] < 50  ? @$report[1]['all_orders']. "%" : "" }}</td>
            <td></td>
        </tr>

        <tr>
            <td>8</td>
            <td>الطلبات المكتمله</td>
            <td>{{@$report[0]['completed_orders']}}</td>
            <td>{{@$report[1]['completed_orders']}}</td>
            <td>{{@$report[0]['completed_orders'] >= 90 ? @$report[0]['completed_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['completed_orders'] >= 70 && @$report[1]['completed_orders'] < 90  ? @$report[1]['completed_orders']. "%" : "" }}</td>
            <td>{{@$report[0]['completed_orders'] >= 50 && @$report[0]['completed_orders'] < 70  ? @$report[0]['completed_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['completed_orders'] < 50  ? @$report[1]['completed_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>9</td>
            <td>الطلبات المرفوضة</td>
            <td>{{@$report[0]['rejected_orders']}}</td>
            <td>{{@$report[1]['rejected_orders']}}</td>
            <td>{{@$report[0]['rejected_orders'] >= 90 ? @$report[0]['rejected_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['rejected_orders'] >= 70 && @$report[1]['rejected_orders'] < 90  ? @$report[1]['rejected_orders']. "%" : "" }}</td>
            <td>{{@$report[0]['rejected_orders'] >= 50 && @$report[0]['rejected_orders'] < 70  ? @$report[0]['rejected_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['rejected_orders'] < 50  ? @$report[1]['rejected_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>10</td>
            <td>الطلبات قيد التحضير</td>
            <td>{{@$report[0]['preparing_orders']}}</td>
            <td>{{@$report[1]['preparing_orders']}}</td>
            <td>{{@$report[0]['preparing_orders'] >= 90 ? @$report[0]['preparing_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['preparing_orders'] >= 70 && @$report[1]['preparing_orders'] < 90  ? @$report[1]['preparing_orders']. "%" : "" }}</td>
            <td>{{@$report[0]['preparing_orders'] >= 50 && @$report[0]['preparing_orders'] < 70  ? @$report[0]['preparing_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['preparing_orders'] < 50  ? @$report[0]['preparing_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>11</td>
            <td>الطلبات قيد الانتظار</td>
            <td>{{@$report[0]['waiting_orders']}}</td>
            <td>{{@$report[1]['waiting_orders']}}</td>
            <td>{{@$report[0]['waiting_orders'] >= 90 ? @$report[0]['waiting_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['waiting_orders'] >= 70 && @$report[1]['waiting_orders'] < 90  ? @$report[1]['waiting_orders']. "%" : "" }}</td>
            <td>{{@$report[0]['waiting_orders'] >= 50 && @$report[0]['waiting_orders'] < 70  ? @$report[0]['waiting_orders']. "%" : "" }}</td>
            <td>{{@$report[1]['waiting_orders'] < 50  ? @$report[1]['waiting_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>12</td>
            <td>التقييمات</td>
            <td>{{@$report[0]['feed_back']}}</td>
            <td>{{@$report[1]['feed_back']}}</td>
            <td>{{@$report[0]['feed_back'] >= 90 ? @$report[0]['feed_back']. "%" : "" }}</td>
            <td>{{@$report[1]['feed_back'] >= 70 && @$report[1]['feed_back'] < 90  ? @$report[1]['feed_back']. "%" : "" }}</td>
            <td>{{@$report[0]['feed_back'] >= 50 && @$report[0]['feed_back'] < 70  ? @$report[0]['feed_back']. "%" : "" }}</td>
            <td>{{@$report[1]['feed_back'] < 50  ? @$report[1]['feed_back']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>13</td>
            <td>الشكاوي</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>14</td>
            <td>حالة النظام</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>15</td>
            <td>الاعطال</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>16</td>
            <td>الثغرات</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>17</td>
            <td>ﺍﻟﻮﻗﺖ ﺍﻟﻤﺴﺘﻐﺮﻕ ﻟﺤﻞ  ﺍﻟﻌﻄﻞ</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
