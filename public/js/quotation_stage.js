
$.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
});

$(function() {
  $("form[name = quotationDetails_form]").keypress(function (e) {
    if (e.which === 13) {
      return false;
    }
  });

  //得意先検索
  $('#serch_customer').click( //起動するボタンなどのid名を指定
    function(){
      var keyword = $('.bf_select2').find('#customer_keyword').val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/ajax/search-customer',
        type:'GET',
        data:{
          "keyword": keyword
        },
        dataType:'text',
        contentType: 'application/json',
      }).done(function (data){
        var data1 = $.parseJSON(data);
        $(".addTr").remove();
        for (var i=0; i<data1.length; i++) {
          $('#serch-customer-table').append(
            '<tr class="addTr"><td class="w50">' + '<input type="radio" class="selected-row"name="selected-row">' + '</td>' +
            '<td class="w50">' + data1[i]['id']  + '</td>' +
            '<td class="w200">' + data1[i].name + '</td>' +
            '<td class="w200">' + data1[i].address + '</td>' +
            '<td class="w200">' + data1[i].tel + '</td>' +
            '<td class="w200">' + data1[i].FAX + '</td>' +
            '<td class="w200">' + data1[i].staffs + '</td></tr>') ;
          }
        }).fail(function(jqXHR,textStatus,errorThrown){
          alert('ファイルの取得に失敗しました。');
          console.log("ajax通信に失敗しました")
          console.log(jqXHR.status);
          console.log(textStatus);
          console.log(errorThrown);
        });
      }
    );
    $('#in-modal-serch-customer').click( //起動するボタンなどのid名を指定
      function(){
        var keyword2 = $('#modal-keyword').val();
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url:'/ajax/search-customer',
          type:'GET',
          data:{
            "keyword": keyword2
          },
          dataType:'text',
          contentType: 'application/json',
        }).done(function (data){
          var data1 = $.parseJSON(data);
          $(".addTr").remove();
          for (var i=0; i<data1.length; i++) {
            $('#serch-customer-table').append(
              '<tr class="addTr"><td class="w50">' + '<input type="radio" class="selected-row" name="selected-row">' + '</td>' +
              '<td class="w50">' + data1[i]['id'] + '</td>' +
              '<td class="w200">' + data1[i].name + '</td>' +
              '<td class="w200">' + data1[i].address + '</td>' +
              '<td class="w200">' + data1[i].tel + '</td>' +
              '<td class="w200">' + data1[i].FAX + '</td>' +
              '<td class="w200">' + data1[i].staffs + '</td></tr>') ;
            }
          }).fail(function(jqXHR,textStatus,errorThrown){
            alert('ファイルの取得に失敗しました。');
            console.log("ajax通信に失敗しました")
            console.log(jqXHR.status);
            console.log(textStatus);
            console.log(errorThrown);
          });
        }
      );
      $('#ok-confirm').click(function() {
        var selected_id = $('input:radio[name="selected-row"]:checked').parent().next('.w50').text();
        var selected_name = $('input:radio[name="selected-row"]:checked').parent().next().next('.w200').text();
        $('#customer_id').val(selected_id);
        $('#customer_keyword').val(selected_name);
        $('.js-modal').fadeOut();

      });
      $('#ng-confirm').click(function() {
        $('.js-modal').fadeOut();
      });

      //参照複写
      $('#modal-serch-quotaion-btn').click( //起動するボタンなどのid名を指定
        function(){
          var keyword = $('#modal-serch-quotaion').val();
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/ajax/search-quotation',
            type:'GET',
            data:{
              "keyword": keyword
            },
            dataType:'text',
            contentType: 'application/json',
          }).done(function (info){
            var data1 = $.parseJSON(info);
            $(".original-tr").remove();
            for (var i=0; i<data1.length; i++) {
              $('#modal-quotation-table').append(
                '<tr class="original-tr"><td>' + '<input type="radio" name="select-quotation" class="select-quotation">' + '</td>' +
                '<td class="">' + data1[i].id + '</td>' +
                '<td class="">' + data1[i].name + '</td>' +
                '<td class="">' + data1[i].title + '</td>' +
                '<td class="">' + data1[i].staffs + '</td>' +
                '<td class="">' + data1[i].which_document + '</td>' +
                '<td class="">' + data1[i].which_company + '</td></tr>') ;
              }
            }).fail(function(jqXHR,textStatus,errorThrown){
              alert('ファイルの取得に失敗しました。');
              console.log("ajax通信に失敗しました")
              console.log(jqXHR.status);
              console.log(textStatus);
              console.log(errorThrown);
            });
          }
        );
        //参照複写詳細表示
        $(document).on('change','.select-quotation',function() {
          var quotation_id =  $('input:radio[name="select-quotation"]:checked').parent().next().text();
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/ajax/search-quotation-detail',
            type:'GET',
            data:{
              "keyword": quotation_id
            },
            dataType:'text',
            contentType: 'application/json',
          }).done(function (info){
            var data1 = $.parseJSON(info);
            $(".detail-tr").remove();
            for (var i=0; i<data1.length; i++) {
              if (data1[i].title == null) {
                data1[i].title = "";
              }
              if (data1[i].standard == null) {
                data1[i].standard = "";
              }
              if (data1[i].quantity == null) {
                data1[i].quantity = "";
              }
              if (data1[i].unit == null) {
                data1[i].unit = "";
              }
              if (data1[i].price == null) {
                data1[i].price = "";
              }
              if (data1[i].bugakari == null) {
                data1[i].bugakari = "";
              }
              $('#modal-quotaion-detail-table').append(
                '<tr class="detail-tr"><td class="w50">' + '<input type="checkbox" name="detail" class="select-quotaion-detail">' + '</td>' +
                '<td class="w50">' + data1[i].title + '</td>' +
                '<td class="w200">' + data1[i].standard + '</td>' +
                '<td class="w200">' + data1[i].quantity + '</td>' +
                '<td class="w200">' + data1[i].unit + '</td>' +
                '<td class="w200">' + data1[i].price + '</td>'+
                '<td class="w200" style="display:none;">' + data1[i].bugakari + '</td>');
              }
            }).fail(function(jqXHR,textStatus,errorThrown){
              alert('ファイルの取得に失敗しました。');
              console.log("ajax通信に失敗しました")
              console.log(jqXHR.status);
              console.log(textStatus);
              console.log(errorThrown);
            });
          });

          $('#confirm').click( //起動するボタンなどのid名を指定
            function(){
              var max_hier_arr = [];
              $('.key_event').each(function(td) {
                var hier1 = Number($(this).val());
                if (isNaN(hier1)) {
                  hier1 = "";
                }
                max_hier_arr.push(hier1);
              });
              var max_hier = Math.max.apply(null,max_hier_arr);
              var titles = [];
              var standards = [];
              var quantities = [];
              var units = [];
              var prices = [];
              var bugakaris = [];
              $('[class="select-quotaion-detail"]:checked').each(function(e){
                titles.push($(this).parent().next().text());
                standards.push($(this).parent().next().next().text());
                quantities.push($(this).parent().next().next().next().text());
                units.push($(this).parent().next().next().next().next().text());
                prices.push($(this).parent().next().next().next().next().next().text());
                bugakaris.push($(this).parent().next().next().next().next().next().next().text());
              });
              var countArr = titles.length;
              for (var i = 0; i < countArr; i++) {
                var default_tr = '<tr  class="clone_tr">'+
                '<td class="alignRight">'+'<input class="hier_ref key_event hier" name="hier[]" value = "" type="text">'+'</td>' +
                '<td class="alignRight">'+'<input class="title_ref " name="title[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="standard_ref standard" name="standard[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="quantity_ref quantity" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="unit_ref unit" name="unit[]" type="text" value = "" >'+'</td>'+
                '<td class="alignRight">'+'<input class="price_ref price" name="input_price[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="bugakari_ref bugakari" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                '<td class="alignRight" class = "unit-price">'+'</td>'+
                '<td class="alignRight"class="total">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'<input type="text" class="remark" rows="2" cols="30" name="input_remark[]" >'+'</td>'+
                '<input type="hidden" name="details_total[]" value="" class="details_total">'+
                '<input type="hidden" name="details_total_middle[]" value="" class="details_total_middle">'+
                '</tr>';
                $('#tree').append(default_tr);
                $('.hier_ref').attr('class','hier' + i );
                $('.hier'+i).addClass('key_event');
                $('.hier'+i).addClass('hier');
                $('.title_ref').attr('class','title' + i);
                $('.standard_ref').attr('class','standard' + i);
                $('.quantity_ref').attr('class','quantity' + i);
                $('.quantity'+i).addClass('quantity');
                $('.unit_ref').attr('class','unit' + i);
                $('.price_ref').attr('class','price' + i);
                $('.price'+i).addClass('price');
                $('.bugakari_ref').attr('class','bugakari' + i);
                $('.bugakari'+i).addClass('bugakari');
                $('.clone_tr').find('.hier' +i).val(max_hier+i+1);
                $('.clone_tr').find('.title' +i).val(titles[i]);
                $('.clone_tr').find('.standard'+i).val(standards[i]);
                $('.clone_tr').find('.quantity'+i).val(quantities[i]);
                $('.clone_tr').find('.unit'+i).val(units[i]);
                $('.clone_tr').find('.price'+i).val(prices[i]);
                $('.clone_tr').find('.bugakari'+i).val(bugakaris[i]);

              }
              $('.js-modal').fadeOut();
            }

          );
          $('#ng-confirm-detail').click(function() {
            $('.js-modal').fadeOut();
          });

          function add(){
            var count = 0;
            //Shift+Enterで階層追加
            $("body").on('keydown','.key_event',function(event) {

              if(event.shiftKey){
                if(event.keyCode === 13){
                  count++;
                  var hier_base = $(this).val();
                  var hier_child = hier_base + "-" + 1;
                  var default_tr = '<tr  class="clone_tr">'+
                  '<td class="alignRight">'+'<input class="hier_add key_event hier" name="hier[]" value = "" type="text" 　	>'+'</td>' +
                  '<td class="alignRight">'+'<input class="title_add title" name="title[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="standard_add standard" name="standard[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="quantity_add quantity" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="unit_add unit" name="unit[]" type="text" value = "" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="price_add price" name="input_price[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="bugakari_add bugakari" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                  '<td class="alignRight" class = "unit-price">'+'</td>'+
                  '<td class="alignRight"class="total">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'<input type="text" class="remark" rows="2" cols="30" name="input_remark[]" >'+'</td>'+
                  '<input type="hidden" name="details_total[]" value="" class="details_total">'+
                  '<input type="hidden" name="details_total_middle[]" value="" class="details_total_middle">'+

                  '</tr>';
                  var addElement = $(this).parent().parent().after(default_tr);
                  $(this).closest('tr').next('tr').find('.key_event').val(hier_child);
                  // $(this).closest('tr').next('tr').find('.key_event').focus();
                }
              }
              //Alt+Enterで兄弟追加
              if(event.altKey){
                if(event.keyCode === 13){
                  var hier_base = $(this).val();
                  var hier_val = Number(hier_base.slice(-1))+1
                  hier_base = hier_base.slice(0, -1);
                  var hier_bro = hier_base + hier_val;
                  var default_tr = '<tr  class="clone_tr">'+
                  '<td class="alignRight">'+'<input class="hier_add key_event hier" name="hier[]" value = "" type="text" 　	>'+'</td>' +
                  '<td class="alignRight">'+'<input class="title_add title" name="title[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="standard_add standard" name="standard[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="quantity_add quantity" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="unit_add unit" name="unit[]" type="text" value = "" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="price_add price" name="input_price[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="bugakari_add bugakari" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                  '<td class="alignRight" class = "unit-price">'+'</td>'+
                  '<td class="alignRight"class="total">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'<input type="text" class="remark" rows="2" cols="30" name="input_remark[]" >'+'</td>'+
                  '<input type="hidden" name="details_total[]" value="" class="details_total">'+
                  '<input type="hidden" name="details_total_middle[]" value="" class="details_total_middle">'+
                  '</tr>';
                  var addElement = $(this).parent().parent().after(default_tr);
                  $(this).closest('tr').next('tr').find('.key_event').val(hier_bro);
                  // $(this).closest('tr').next('tr').find('.key_event').focus();
                }
              }
              //Shift+deleteで削除
              $("body").on('keydown','.key_event',function(event) {
                if(event.shiftKey){
                  if(event.keyCode === 8){
                    var row = $(this).closest('tr').remove();
                    $(row).remove();
                  }
                }
              });
            });
          }
          add();
        });


        $(function(){
          function getData(){
            var d=[];
            var subtotal = 0;
            var totalProfit = 0;
            const tax_rate = 0.1;
            var cost1 = {0:0,1:0,2:0,3:0,4:0,5:0,6:0,7:0,8:0,9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0,17:0,18:0,19:0,20:0,21:0,22:0,23:0,24:0,25:0,26:0,27:0,28:0,29:0,30:0};
            var cost2 = {0:0,1:0,2:0,3:0,4:0,5:0,6:0,7:0,8:0,9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0,17:0,18:0,19:0,20:0,21:0,22:0,23:0,24:0,25:0,26:0,27:0,28:0,29:0,30:0};
            var total4 = 0;
            var profit1 = 0;

            $('#tree .clone_tr').each(function(i, e){
              var dd=[];
              $(this).find('input').each(function(j, el){
                dd.push($(this).val())
                if ($(this).val().slice(0,1) == "-") {
                  $(this).css("color","red");
                }
              });
              d.push(dd);
              if (d[i][5] == "") {
                var price = ""
              }else {
                var price = d[i][5];
              }
              if (d[i][6] == "") {
                var bugakari = ""
              }else {
                var bugakari = d[i][6];
              }
              if (d[i][3] == "") {
                var quantity = ""
              }else {
                var quantity = d[i][3];
              }
              //単価
              var unitPrice = Math.floor(parseInt(price) * (parseInt(bugakari)));
              //原価
              var cost = Math.floor(parseInt(quantity) * parseInt(price));
              //見積もり
              var subtotalEstimate = Math.floor(unitPrice * quantity);
              //利益
              var profit = Math.floor(subtotalEstimate - cost);
              //各行の計算
              //単価
              if (!isNaN(unitPrice) && unitPrice !== 0) {
                $('#tree tr').eq(i+1).children('td').eq(7).text(unitPrice);
              }else {
                $('#tree tr').eq(i+1).children('td').eq(7).text("");
              }
              //原価
              if (!isNaN(cost) && cost != 0) {
                $('#tree tr').eq(i+1).children('td').eq(9).text(cost);
              }else {
                $('#tree tr').eq(i+1).children('td').eq(9).text("");
              }
              //見積もり
              if (!isNaN(subtotalEstimate) && subtotalEstimate != 0) {
                $('#tree tr').eq(i+1).children('td').eq(8).text(subtotalEstimate);
              }else {
                $('#tree tr').eq(i+1).children('td').eq(8).text("");
              }
              //利益
              if (!isNaN(profit) && subtotalEstimate !=0 && cost != 0) {
                $('#tree tr').eq(i+1).children('td').eq(10).text(profit);
              }else {
                $('#tree tr').eq(i+1).children('td').eq(10).text("");
              }
              //行合計の計算
              //小計
              if (!isNaN(subtotalEstimate)) {
                subtotal +=  subtotalEstimate;
              }
              //消費税
              var tax = Math.floor(subtotal * tax_rate);
              //見積もり
              var totalEstimate = Math.floor(subtotal + tax);
              //利益率
              if (!isNaN(subtotalEstimate)) {
                totalProfit += profit;
              }
              var profitRate = ((totalProfit / subtotal) * 100).toFixed(1);
              //表示
              $('#total_small').text(subtotal);
              $('#total_tax').text(tax);
              $('#total').text(totalEstimate);
              if (!isNaN(profitRate)) {
                $('#profit_rate').text(profitRate);
              }
              $(this).find('td').each(function(j, el){
                if ($(this).text().slice(0,1) == "-") {
                  $(this).css("color","red");
                }
              });
            });
            var hier_big_arr = [];
            var hier_middle_arr = [];
            var hier_little_arr = [];
            var ex = /-/g;
            $(d).each(function(i, e){
              var target = d[i][0].match(ex);
              if (target != null) {
                var arr = target.length;
              }else{
                var arr = 0
              }
              if (arr == 0) {
                hier_big_arr.push(d[i][0]);
              }
              if (arr == 1) {
                hier_middle_arr.push(d[i][0]);
              }
              if (arr == 2) {
                hier_little_arr.push(d[i][0]);
              }
            });
            //空削除
            hier_big_arr =  hier_big_arr.filter(n => n);

            //中項目合計
            $('#tree .clone_tr').each(function(i, e){
              var total1 = $(this).children('td').eq(8).text();
              var hier1 = $(this).children('td').find('.hier').val();
              for (var j = 0; j < hier_middle_arr.length; j++) {
                for (var k = 0; k < hier_little_arr.length; k++) {
                  var judge_int = hier_little_arr[k].lastIndexOf('-');
                  var judge_str = hier_little_arr[k].slice(0,judge_int);

                  if (hier1 == hier_little_arr[k] && hier_little_arr[k].match(hier_middle_arr[j]) && judge_str === hier_middle_arr[j]) {
                    cost1[j] = cost1[j] + Number(total1);
                  }
                }
              }

            });
            $('#tree .clone_tr').each(function(i, e){
              var hier2 = $(this).children('td').find('.hier').val();

              for (var j = 0; j < hier_middle_arr.length; j++) {
                if (hier2 == hier_middle_arr[j]) {
                  if (cost1[j] != "") {
                    $('#tree tr').eq(i+1).children('td').eq(8).text(cost1[j]);
                    $('#tree tr').eq(i+1).children('.details_total_middle').val(cost1[j]);
                  }

                }
              }
            });
            //大項目合計
            $('#tree .clone_tr').each(function(i, e){
              var total2 = $(this).children('td').eq(8).text();
              var hier3 = $(this).children('td').find('.hier').val();
              for (var j = 0; j < hier_big_arr.length; j++) {
                for (var k = 0; k < hier_middle_arr.length; k++) {
                  var judge_int = hier_middle_arr[k].lastIndexOf('-');
                  var judge_str = hier_middle_arr[k].slice(0,judge_int);
                  if (hier3 == hier_middle_arr[k] && hier_middle_arr[k].match(hier_big_arr[j]) && judge_str === hier_big_arr[j]) {
                    cost2[j] = cost2[j] + Number(total2);
                  }
                }
              }
            });

            $('#tree .clone_tr').each(function(i, e){
              var hier3 = $(this).children('td').find('.hier').val();

              for (var j = 0; j < hier_big_arr.length; j++) {
                if (hier3 == hier_big_arr[j]) {
                  if (cost2[j] != "") {
                    $('#tree tr').eq(i+1).children('td').eq(8).text(cost2[j]);
                    $('#tree tr').eq(i+1).children('.details_total').val(cost2[j]);
                  }

                }
              }
            });
            //小計表示
            $('#tree .clone_tr').each(function(i, e){
              var hier4 = $(this).children('td').find('.hier').val();
              var total3 = $(this).children('td').eq(8).text();
              for (var j = 0; j < hier_big_arr.length; j++) {
                if (hier4 == hier_big_arr[j]) {
                  total4 = total4 + Number(total3);
                }
              }
            });
            //利益合計
            $('#tree .clone_tr').each(function(i, e){
              var hier4 = $(this).children('td').eq(0).val();
              var profit2 = $(this).children('td').eq(10).text();
              profit1 = profit1 + Number(profit2);
            });
            //消費税
            var tax2 = Math.floor(total4 * tax_rate);
            //見積もり
            var totalEstimate2 = Math.floor(total4 + tax2);

            var profitRate = ((totalProfit / subtotal) * 100).toFixed(1);
            var profitRate = ((profit1 / total4) * 100).toFixed(1);
            $('#total_small').text(total4);
            $('#total_tax').text(tax2);
            $('#total').text(totalEstimate2);
            $('#profit_rate').text(profitRate);
            $('#sub_total_rq').val(total4);
            $('#total_tax_rq').val(tax2);
            $('#total_rq').val(totalEstimate2);
            if (!isNaN(profitRate)) {
              $('#profit_rate_rq').val(profitRate);
            }else{
              $('#profit_rate_rq').val(0.0);
            }

            $('#profit').val(profit1);
          }
          //ソート処理
          $('#sort').click(function(){
            var arr2=[];
            $('#tree .clone_tr').each(function(i, e){
              var arr=[];
              $(this).find('input').each(function(j, el){
                arr.push($(this).val())
              });
              arr2.push(arr);
            });
            arr2 = JSON.stringify(arr2);
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url:'/ajax/sort-quotation',
              type:'post',
              timeout: 15000,
              data: arr2,

              dataType:'json',
              contentType: 'application/json',
            }).done(function (info){
              // var data1 = $.parseJSON(info);
              var data1 = info;
              console.log(data1)
              data1.sort(function(a, b) {
                if (a[0] == null || b[0] == null) {
                  return -1;
                }
              });
              var leng = data1.length;
              $('.clone_tr').remove();
              var countArr = data1.length;
              for (var i = 0; i < countArr; i++) {
                var default_tr = '<tr  class="clone_tr">'+
                '<td class="alignRight">'+'<input class="hier_add key_event" name="hier[]" value = "" type="text" 　	>'+'</td>' +
                '<td class="alignRight">'+'<input class="title_add" name="title[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="standard_add" name="standard[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="quantity_add" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="unit_add" name="unit[]" type="text" value = "" >'+'</td>'+
                '<td class="alignRight">'+'<input class="price_add" name="input_price[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="bugakari_add" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                '<td class="alignRight" class = "unit-price">'+'</td>'+
                '<td class="alignRight"class="total">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'<input type="text" class="remark_add" rows="2" cols="30" name="input_remark[]" >'+'</td>'+
                '<input type="hidden" name="details_total[]" value="" class="details_total">'+
                '<input type="hidden" name="details_total_middle[]" value="" class="details_total_middle">'+
                '</tr>';
                $('#tree').append(default_tr);
                $('.hier_add').attr('class','hier' + i);
                $('.hier'+i).addClass('key_event');
                $('.hier'+i).addClass('hier');
                $('.title_add').attr('class','title' + i);
                $('.standard_add').attr('class','standard' + i);
                $('.quantity_add').attr('class','quantity' + i);
                $('.quantity'+i).addClass('quantity');
                $('.quantity'+i).addClass('a_right');
                $('.unit_add').attr('class','unit' + i);
                $('.unit'+i).addClass('unit');
                $('.unit'+i).addClass('a_right');
                $('.price_add').attr('class','price' + i);
                $('.price'+i).addClass('price');
                $('.price'+i).addClass('a_right');
                $('.bugakari_add').attr('class','bugakari' + i);
                $('.bugakari'+i).addClass('bugakari');
                $('.bugakari'+i).addClass('a_right');
                $('.remark_add').attr('class','remark' + i);
                $('.remark'+i).addClass('remark');
                if (i<leng) {
                  $('.clone_tr').find('.hier' +i).val(data1[i][0]);
                  $('.clone_tr').find('.title' +i).val(data1[i][1]);
                  $('.clone_tr').find('.standard'+i).val(data1[i][2]);
                  $('.clone_tr').find('.quantity'+i).val(data1[i][3]);
                  $('.clone_tr').find('.unit'+i).val(data1[i][4]);
                  $('.clone_tr').find('.price'+i).val(data1[i][5]);
                  $('.clone_tr').find('.bugakari'+i).val(data1[i][6]);
                  $('.clone_tr').find('.remark'+i).val(data1[i][7]);
                  $('.hier'+i).removeClass('hier'+i);
                  $('.title'+i).removeClass('title'+i);
                  $('.standard'+i).removeClass('standard'+i);
                  $('.quantity'+i).removeClass('quantity'+i);
                  $('.unit'+i).removeClass('unit'+i);
                  $('.price'+i).removeClass('price'+i);
                  $('.bugakari'+i).removeClass('bugakari'+i);
                  $('.remark'+i).removeClass('remark'+i);
                }


              }
              getData();
            }).fail(function(jqXHR,textStatus,errorThrown){
              alert('ファイルの取得に失敗しました。');
              console.log("ajax通信に失敗しました")
              console.log(jqXHR.status);
              console.log(textStatus);
              console.log(errorThrown);
            });
          });
          $(document).on('change','#tree',function() {

            getData();
          });
          getData();
        });

        var data_box = [];
        $('#tree tr').each(function(i, e){
          var data=[];
          $(this).find('input').each(function(j, el){
            data.push($(this).val())
          });
          data_box.push(data);
        });

        // 保存ボタンの処理
        function send(){
          $(document).on("click", "#save", function(e) {

            var $form = $('#quotation_form');
            var param = $form.serializeArray();
            // extends jquery

            var object = {};

            $.each(param, function() {
              if (object[this.name] !== undefined) {
                if (!object[this.name].push) {
                  object[this.name] = [object[this.name]];
                }
                object[this.name].push(this.value || '');
              } else {
                object[this.name] = this.value || '';
              }
            });
            $('#quotation_data').val(Object.entries(object));
            //バリデーション
            //見積もり日付
            // if ($("[name=quote_year]").val() == ""　|| $("[name=quote_month]").val() == "" || $("[name=quote_day]").val() == "") {
            //   alert('見積日付を入力してください。');
            //   return;
            // }
            //担当者
            // if ($("[name=staffs]").val() == "") {
            //   alert('担当者を選択してください。');
            //   return;
            // }
            //得意先
            if ($("[name=customer-name]").val() == "") {
              alert('得意先を選択してください。');
              return;
            }
            //会社選択
            if (!$("input:radio[name='company']:checked").val()) {
              alert('会社を選択してください。');
              return;
            }
            //書類選択
            if (!$("input:radio[name='document']:checked").val()) {
              alert('書類選択を選択してください。');
              return;
            }
            //工事場所
            // if ($("[name=place]").val() == "") {
            //   alert('工事場所を入力してください。');
            //   return;
            // }
            //御支払条件
            // if ($("[name=payment_term]").val() == "") {
            //   alert('御支払条件所を入力してください。');
            //   return;
            // }
            //有効期限
            // if ($("[name=expiration_date]").val() == "") {
            //   alert('有効期限を入力してください。');
            //   return;
            // }
            //工期
            // if($("[name=period_before_year]").val() == ""　|| $("[name=period_before_month]").val() == "" || $("[name=period_before_day]").val() == "") {
            //   alert('工期を入力してください。');
            //   return;
            // }
            // if($("[name=period_after_year]").val() == ""　|| $("[name=period_after_month]").val() == "" || $("[name=period_after_day]").val() == "") {
            //   alert('工期を入力してください。');
            //   return;
            // }

            $("#quotationDetails_form").submit();
          });
        }
        //保存完了画面用
        $(function(){
          var d=[];
          var subtotal = 0;
          var totalProfit = 0;
          const tax_rate = 0.1;
          var cost1 = {0:0,1:0,2:0,3:0,4:0,5:0,6:0,7:0,8:0,9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0,17:0,18:0,19:0,20:0,21:0,22:0,23:0,24:0,25:0,26:0,27:0,28:0,29:0,30:0};
          var cost2 = {0:0,1:0,2:0,3:0,4:0,5:0,6:0,7:0,8:0,9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0,17:0,18:0,19:0,20:0,21:0,22:0,23:0,24:0,25:0,26:0,27:0,28:0,29:0,30:0};
          var total4 = 0;
          var profit1 = 0;
          const formatter = new Intl.NumberFormat();
          $('#show .clone_tr').each(function(i, e){
            var dd=[];
            $(this).find('td').each(function(j, el){
              dd.push($(this).text())
              if ($(this).text().slice(0,1) == "-") {
                $(this).css("color","red");
              }
            });
            d.push(dd);
            var price = d[i][5];
            var bugakari = d[i][6];
            var quantity = d[i][3];
            //単価
            var unitPrice = Math.floor(parseInt(price) * (parseInt(bugakari)));
            //原価
            var cost = Math.floor(parseInt(quantity) * parseInt(price));
            //見積もり
            var subtotalEstimate = Math.floor(unitPrice * quantity);
            //利益
            var profit = Math.floor(subtotalEstimate - cost);
            //各行の計算
            //単価
            if (!isNaN(unitPrice)) {
              $('#show tr').eq(i+1).children('td').eq(7).text(unitPrice);
            }
            //原価
            if (!isNaN(cost) && cost != 0) {
              $('#show tr').eq(i+1).children('td').eq(9).text(cost);
            }else {
              $('#show tr').eq(i+1).children('td').eq(9).text("");
            }
            //見積もり
            if (!isNaN(subtotalEstimate) && subtotalEstimate != 0) {
              $('#show tr').eq(i+1).children('td').eq(8).text(subtotalEstimate);
            }else {
              $('#show tr').eq(i+1).children('td').eq(8).text("");
            }
            //利益
            if (!isNaN(profit)) {
              $('#show tr').eq(i+1).children('td').eq(10).text(profit);
            }
            //行合計の計算
            //小計
            if (!isNaN(subtotalEstimate)) {
              subtotal +=  subtotalEstimate;
            }
            //消費税
            var tax = Math.floor(subtotal * tax_rate);
            //見積もり
            var totalEstimate = Math.floor(subtotal + tax);
            //利益率
            if (!isNaN(subtotalEstimate)) {
              totalProfit += profit;
            }
            var profitRate = ((totalProfit / subtotal) * 100).toFixed(1);
            //表示
            $('#total_small').text(subtotal);
            $('#total_tax').text(tax);
            $('#total').text(totalEstimate);
            if (!isNaN(profitRate)) {
              $('#profit_rate').text(profitRate);
            }else{
              $('#profit_rate').text(0)
            }
            $(this).find('td').each(function(j, el){
              if ($(this).text().slice(0,1) == "-") {
                $(this).css("color","red");
              }
            });
          });
          var hier_big_arr = [];
          var hier_middle_arr = [];
          var hier_little_arr = [];
          var ex = /-/g;
          $(d).each(function(i, e){
            var target = d[i][0].match(ex);
            if (target != null) {
              var arr = target.length;
            }else{
              var arr = 0
            }
            if (arr == 0) {
              hier_big_arr.push(d[i][0]);
            }
            if (arr == 1) {
              hier_middle_arr.push(d[i][0]);
            }
            if (arr == 2) {
              hier_little_arr.push(d[i][0]);
            }
          });
          //空削除
          hier_big_arr =  hier_big_arr.filter(n => n);
          //中項目合計
          $('#show .clone_tr').each(function(i, e){
            var total1 = $(this).children('td').eq(8).text();
            var hier1 = $(this).children('td').eq(0).text();
            for (var j = 0; j < hier_middle_arr.length; j++) {
              for (var k = 0; k < hier_little_arr.length; k++) {
                var judge_int = hier_little_arr[k].lastIndexOf('-');
                var judge_str = hier_little_arr[k].slice(0,judge_int);
                if (hier1 == hier_little_arr[k] && hier_little_arr[k].match(hier_middle_arr[j]) && judge_str === hier_middle_arr[j]) {
                  cost1[j] = cost1[j] + Number(total1);
                }
              }
            }
          });
          $('#show .clone_tr').each(function(i, e){
            var hier2 = $(this).children('td').eq(0).text();

            for (var j = 0; j < hier_middle_arr.length; j++) {
              if (hier2 == hier_middle_arr[j]) {
                if (cost1[j] != "") {
                  $('#show tr').eq(i+1).children('td').eq(8).text(cost1[j]);
                }

              }
            }
          });
          //大項目合計
          $('#show .clone_tr').each(function(i, e){
            var total2 = $(this).children('td').eq(8).text();
            var hier3 = $(this).children('td').eq(0).text();
            for (var j = 0; j < hier_big_arr.length; j++) {
              for (var k = 0; k < hier_middle_arr.length; k++) {
                var judge_int = hier_middle_arr[k].lastIndexOf('-');
                var judge_str = hier_middle_arr[k].slice(0,judge_int);
                if (hier3 == hier_middle_arr[k] && hier_middle_arr[k].match(hier_big_arr[j]) && judge_str === hier_big_arr[j]) {
                  cost2[j] = cost2[j] + Number(total2);
                }
              }
            }
          });

          $('#show .clone_tr').each(function(i, e){
            var hier3 = $(this).children('td').eq(0).text();

            for (var j = 0; j < hier_big_arr.length; j++) {
              if (hier3 == hier_big_arr[j]) {
                if (cost2[j] != "") {
                  $('#show tr').eq(i+1).children('td').eq(8).text(cost2[j]);
                }

              }
            }
          });
          //小計表示
          $('#show .clone_tr').each(function(i, e){
            var hier4 = $(this).children('td').eq(0).text();
            var total3 = $(this).children('td').eq(8).text();
            for (var j = 0; j < hier_big_arr.length; j++) {
              if (hier4 == hier_big_arr[j]) {
                total4 = total4 + Number(total3);
              }
            }
          });
          //利益合計
          $('#show .clone_tr').each(function(i, e){
            var hier4 = $(this).children('td').eq(0).text();
            var profit2 = $(this).children('td').eq(10).text();
            profit1 = profit1 + Number(profit2);
          });
          //消費税
          var tax2 = Math.floor(total4 * tax_rate);
          //見積もり
          var totalEstimate2 = Math.floor(total4 + tax2);
          //利益率
          // if (!isNaN(subtotalEstimate)) {
          //   totalProfit += profit;
          // }
          var profitRate = ((profit1 / total4) * 100).toFixed(1);
          total4 = formatter.format(total4);
          tax2 = formatter.format(tax2);
          totalEstimate2 = formatter.format(totalEstimate2);
          $(document).ready(function(){

            $('#show_total_small').text('小計: ¥' + total4);
            $('#show_total_tax').text('消費税額: ￥' + tax2);
            $('#show_total').text('御見積金額: ￥' + totalEstimate2);
            if (!isNaN(profitRate)) {
              $('#show_profit_rate').text('利益率: ' + profitRate + '%');
            }
          });
        });

        window.onpageshow = function(event) {
          if (event.persisted) {
            window.location.reload();
          }
        };
        $(document).ready(function(){
          $(document).on('change','.hier',function(){
            var text = $(this).val();
            var str = text.replace(/[Ａ-Ｚａ-ｚ０-９！＂＃＄％＆＇（）＊＋，－．／：；＜＝＞？＠［＼］＾＿｀｛｜｝]/g, function(s) {
              return String.fromCharCode(s.charCodeAt(0) - 0xfee0);
            }).replace(/[−]/g, "-");

            $(this).val(str);
          });
          $(document).on('change','.quantity',function(){
            var text = $(this).val();
            var str = text.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
              return String.fromCharCode(s.charCodeAt(0) - 65248);
            });
            $(this).val(str);
          });
          $(document).on('change','.price',function(){
            var text = $(this).val();
            if (text.match('-')) {
              $(this).css("color","red");
            }
            var str = text.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
              return String.fromCharCode(s.charCodeAt(0) - 65248);
            });
            $(this).val(str);
          });
          $(document).on('change','.bugakari',function(){
            var text = $(this).val();
            var str = text.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
              return String.fromCharCode(s.charCodeAt(0) - 65248);
            });
            $(this).val(str);
          });
        })

        $(document).on("keydown","input", function(e) {
          var base_n = $(".clone_tr").find('input').length;
          var clone_count = $(".clone_tr").length;
          var n = base_n / clone_count -1;
          if (e.which == 13)
          {
            e.preventDefault();
            var nextIndex = $('.clone_tr').find('input').index(this) + 1 ;
            var nextIndex2 = $('.clone_tr').find('input').index(this) + 2 ;

            if(nextIndex < base_n) {
              if ($('.clone_tr').find('input').index(this) == 0) {
                $('.clone_tr').find('input')[1].focus();
              }else {
                console.log(nextIndex)
                // if (nextIndex % 8 === 0) {
                //   $(':focus').parent().parent().next('tr').children().find('.key_event').focus();
                // }else {
                  //次のやつにfocus
                  $('.clone_tr').find('input')[nextIndex].focus();
                // }
              }
            }
          }
        });
