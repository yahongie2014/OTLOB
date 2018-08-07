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
            <td>{{$toDayData['all_users']}}</td>
            <td>{{$lastDay['all_users']}}</td>
            <td>{{$progressLevel['all_users'] >= 90 ? $progressLevel['all_users'] . "%" : "" }}</td>
            <td>{{$progressLevel['all_users'] >= 70 && $progressLevel['all_users'] < 90  ? $progressLevel['all_users'] . "%": "" }}</td>
            <td>{{$progressLevel['all_users'] >= 50 && $progressLevel['all_users'] < 70  ? $progressLevel['all_users'] . "%": "" }}</td>
            <td>{{$progressLevel['all_users'] < 50  ? $progressLevel['all_users'] . "%": "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td>عدد مزودي الخدمة</td>
            <td>{{$toDayData['providers']}}</td>
            <td>{{$lastDay['providers']}}</td>
            <td>{{$progressLevel['providers'] >= 90 ? $progressLevel['providers']. "%" : "" }}</td>
            <td>{{$progressLevel['providers'] >= 70 && $progressLevel['providers'] < 90  ? $progressLevel['providers']. "%" : "" }}</td>
            <td>{{$progressLevel['providers'] >= 50 && $progressLevel['providers'] < 70  ? $progressLevel['providers']. "%" : "" }}</td>
            <td>{{$progressLevel['providers'] < 50  ? $progressLevel['providers']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>3</td>
            <td>عدد المنتجات</td>
            <td>{{$toDayData['all_products']}}</td>
            <td>{{$lastDay['all_products']}}</td>
            <td>{{$progressLevel['all_products'] >= 90 ? $progressLevel['all_products']. "%" : "" }}</td>
            <td>{{$progressLevel['all_products'] >= 70 && $progressLevel['all_products'] < 90  ? $progressLevel['all_products']. "%" : "" }}</td>
            <td>{{$progressLevel['all_products'] >= 50 && $progressLevel['all_products'] < 70  ? $progressLevel['all_products']. "%" : "" }}</td>
            <td>{{$progressLevel['all_products'] < 50  ? $progressLevel['all_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>4</td>
            <td>المنتجات قيد التفعيل</td>
            <td>{{$toDayData['waiting_products']}}</td>
            <td>{{$lastDay['waiting_products']}}</td>
            <td>{{$progressLevel['waiting_products'] >= 90 ? $progressLevel['waiting_products']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_products'] >= 70 && $progressLevel['waiting_products'] < 90  ? $progressLevel['waiting_products']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_products'] >= 50 && $progressLevel['waiting_products'] < 70  ? $progressLevel['waiting_products']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_products'] < 50  ? $progressLevel['waiting_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>5</td>
            <td>المنتجات المفعله</td>
            <td>{{$toDayData['active_products']}}</td>
            <td>{{$lastDay['active_products']}}</td>
            <td>{{$progressLevel['active_products'] >= 90 ? $progressLevel['active_products']. "%" : "" }}</td>
            <td>{{$progressLevel['active_products'] >= 70 && $progressLevel['active_products'] < 90  ? $progressLevel['active_products']. "%" : "" }}</td>
            <td>{{$progressLevel['active_products'] >= 50 && $progressLevel['active_products'] < 70  ? $progressLevel['active_products']. "%" : "" }}</td>
            <td>{{$progressLevel['active_products'] < 50  ? $progressLevel['active_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>6</td>
            <td>المنتجات الموقوفة</td>
            <td>{{$toDayData['deactivated_products']}}</td>
            <td>{{$lastDay['deactivated_products']}}</td>
            <td>{{$progressLevel['deactivated_products'] >= 90 ? $progressLevel['deactivated_products']. "%" : "" }}</td>
            <td>{{$progressLevel['deactivated_products'] >= 70 && $progressLevel['deactivated_products'] < 90  ? $progressLevel['deactivated_products'] . "%": "" }}</td>
            <td>{{$progressLevel['deactivated_products'] >= 50 && $progressLevel['deactivated_products'] < 70  ? $progressLevel['deactivated_products']. "%" : "" }}</td>
            <td>{{$progressLevel['deactivated_products'] < 50  ? $progressLevel['deactivated_products']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>7</td>
            <td>عدد الطلبات</td>
            <td>{{$toDayData['all_orders']}}</td>
            <td>{{$lastDay['all_orders']}}</td>
            <td>{{$progressLevel['all_orders'] >= 90 ? $progressLevel['all_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['all_orders'] >= 70 && $progressLevel['all_orders'] < 90  ? $progressLevel['all_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['all_orders'] >= 50 && $progressLevel['all_orders'] < 70  ? $progressLevel['all_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['all_orders'] < 50  ? $progressLevel['all_orders']. "%" : "" }}</td>
            <td></td>
        </tr>

        <tr>
            <td>8</td>
            <td>الطلبات المكتمله</td>
            <td>{{$toDayData['completed_orders']}}</td>
            <td>{{$lastDay['completed_orders']}}</td>
            <td>{{$progressLevel['completed_orders'] >= 90 ? $progressLevel['completed_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['completed_orders'] >= 70 && $progressLevel['completed_orders'] < 90  ? $progressLevel['completed_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['completed_orders'] >= 50 && $progressLevel['completed_orders'] < 70  ? $progressLevel['completed_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['completed_orders'] < 50  ? $progressLevel['completed_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>9</td>
            <td>الطلبات المرفوضة</td>
            <td>{{$toDayData['rejected_orders']}}</td>
            <td>{{$lastDay['rejected_orders']}}</td>
            <td>{{$progressLevel['rejected_orders'] >= 90 ? $progressLevel['rejected_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['rejected_orders'] >= 70 && $progressLevel['rejected_orders'] < 90  ? $progressLevel['rejected_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['rejected_orders'] >= 50 && $progressLevel['rejected_orders'] < 70  ? $progressLevel['rejected_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['rejected_orders'] < 50  ? $progressLevel['rejected_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>10</td>
            <td>الطلبات قيد التحضير</td>
            <td>{{$toDayData['preparing_orders']}}</td>
            <td>{{$lastDay['preparing_orders']}}</td>
            <td>{{$progressLevel['preparing_orders'] >= 90 ? $progressLevel['preparing_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['preparing_orders'] >= 70 && $progressLevel['preparing_orders'] < 90  ? $progressLevel['preparing_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['preparing_orders'] >= 50 && $progressLevel['preparing_orders'] < 70  ? $progressLevel['preparing_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['preparing_orders'] < 50  ? $progressLevel['preparing_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>11</td>
            <td>الطلبات قيد الانتظار</td>
            <td>{{$toDayData['waiting_orders']}}</td>
            <td>{{$lastDay['waiting_orders']}}</td>
            <td>{{$progressLevel['waiting_orders'] >= 90 ? $progressLevel['waiting_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_orders'] >= 70 && $progressLevel['waiting_orders'] < 90  ? $progressLevel['waiting_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_orders'] >= 50 && $progressLevel['waiting_orders'] < 70  ? $progressLevel['waiting_orders']. "%" : "" }}</td>
            <td>{{$progressLevel['waiting_orders'] < 50  ? $progressLevel['waiting_orders']. "%" : "" }}</td>
            <td></td>
        </tr>
        <tr>
            <td>12</td>
            <td>التقييمات</td>
            <td>{{$toDayData['feed_back']}}</td>
            <td>{{$lastDay['feed_back']}}</td>
            <td>{{$progressLevel['feed_back'] >= 90 ? $progressLevel['feed_back']. "%" : "" }}</td>
            <td>{{$progressLevel['feed_back'] >= 70 && $progressLevel['feed_back'] < 90  ? $progressLevel['feed_back']. "%" : "" }}</td>
            <td>{{$progressLevel['feed_back'] >= 50 && $progressLevel['feed_back'] < 70  ? $progressLevel['feed_back']. "%" : "" }}</td>
            <td>{{$progressLevel['feed_back'] < 50  ? $progressLevel['feed_back']. "%" : "" }}</td>
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
