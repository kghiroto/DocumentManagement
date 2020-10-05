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
        console.log(data1);
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
        console.log(keyword2);
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
                '<tr class="original-tr"><td>' + '<input type="radio" name="select-quotaion" id="select-quotaion">' + '</td>' +
                '<td class="w50">' + data1[i].id + '</td>' +
                '<td class="w200">' + data1[i].title + '</td>' +
                '<td class="w200">' + data1[i].staffs + '</td>' +
                '<td class="w200">' + data1[i].which_document + '</td>' +
                '<td class="w200">' + data1[i].which_company + '</td></tr>') ;
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
        $('.select-quotaion').change(function() {
          var quotation_id =  $('input:radio[name="select-quotaion"]:checked').parent().next().text();
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
              console.log(countArr);
              for (var i = 0; i < countArr; i++) {
                var default_tr = '<tr  class="clone_tr">'+
                '<td class="alignRight">'+'<input class="hier_ref key_event hier" name="hier[]" value = "" type="text" id=""　	>'+'</td>' +
                '<td class="alignRight">'+'<input class="title_ref " name="title[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="standard_ref standard" name="standard[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="quantity_ref quantity" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="unit_ref unit" name="unit[]" type="text" value = "" >'+'</td>'+
                '<td class="alignRight">'+'<input class="price_ref price" name="input_price[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="bugakari_ref bugakari" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                '<td class="alignRight" class = "unit-price">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'<textarea class="remark" rows="2" cols="30" name="input_remark[]" id="edit_row">'+'</textarea>'+'</td>'+
                '<input type ="hidden" value=""name = "hidden_id[]">'+
                '</tr>';
                $('#tree').append(default_tr);
                $('.hier_ref').attr('class','hier' + i );
                $('.hier'+i).addClass('key_event');
                $('.title_ref').attr('class','title' + i);
                $('.standard_ref').attr('class','standard' + i);
                $('.quantity_ref').attr('class','quantity' + i);
                $('.unit_ref').attr('class','unit' + i);
                $('.price_ref').attr('class','price' + i);
                $('.bugakari_ref').attr('class','bugakari' + i);

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
            //Shift+Enterで追加
            $("body").on('keydown','.key_event',function(event) {
              if(event.shiftKey){
                if(event.keyCode === 13){
                  var default_tr = '<tr  class="clone_tr">'+
                  '<td class="alignRight">'+'<input class="hier_add key_event" name="hier[]" value = "" type="text" id=""　	>'+'</td>' +
                  '<td class="alignRight">'+'<input class="title_add" name="title[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="standard_add" name="standard[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="quantity_add" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="unit_add" name="unit[]" type="text" value = "" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="price_add" name="input_price[]" value = "" type="text" >'+'</td>'+
                  '<td class="alignRight">'+'<input class="bugakari_add" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                  '<td class="alignRight" class = "unit-price">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'</td>'+
                  '<td class="alignRight">'+'<textarea class="remark" rows="2" cols="30" name="input_remark[]" id="edit_row">'+'</textarea>'+'</td>'+
                  '<input type ="hidden" value=""name = "hidden_id[]">'+
                  '</tr>';
                  var addElement = $(this).parent().parent().after(default_tr);

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

            $('#tree .clone_tr').each(function(i, e){
              var dd=[];
              $(this).find('input').each(function(j, el){
                dd.push($(this).val())
              });
              d.push(dd);
              var price = d[i][5];
              var bugakari = d[i][6];
              var quantity = d[i][3];
              //単価
              var unitPrice = Math.floor(parseInt(price) * (parseInt(bugakari) +100) / 100);
              //原価
              var cost = Math.floor(parseInt(quantity) * parseInt(price));
              //見積もり
              var subtotalEstimate = Math.floor(unitPrice * quantity);
              //利益
              var profit = Math.floor(subtotalEstimate - cost);
              //各行の計算
              //単価
              if (!isNaN(unitPrice)) {
                $('#tree tr').eq(i+1).children('td').eq(7).text(unitPrice);
              }
              //原価
              if (!isNaN(cost)) {
                $('#tree tr').eq(i+1).children('td').eq(8).text(cost);
              }
              //見積もり
              if (!isNaN(subtotalEstimate)) {
                $('#tree tr').eq(i+1).children('td').eq(9).text(subtotalEstimate);
              }
              //利益
              if (!isNaN(profit)) {
                $('#tree tr').eq(i+1).children('td').eq(10).text(profit);
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
            });
            // $('#tree tr').eq(i+1).children('td').eq(0).append(arr2[i][0]);
            //
            // var target = $('#tree tr').eq(i+1).children('td').eq(0).text();

            // target.replace(/arr2[i][0]/g,"");




          }
          //ソート処理
          $('#sort').click(function(){
            var arr2=[];
            $('#tree .clone_tr').each(function(i, e){
              var arr=[];
              $(this).find('input').each(function(j, el){
                if ($(this).val() != "") {
                  arr.push($(this).val())
                }

              });
              arr2.push(arr);
            });
            console.log(arr2);
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url:'/ajax/sort-quotation',
              type:'GET',
              timeout: 15000,
              data:{
                "keyword": arr2
              },
              dataType:'text',
              contentType: 'application/json',
            }).done(function (info){
              var data1 = $.parseJSON(info);
              data1.sort(function(a, b) {
                if (a[0] == null || b[0] == null) {
                  return -1;
                }
              });
              var leng = data1.length;
              var dif = 30 - leng;
              $('.clone_tr').remove();
              var countArr = data1.length+dif;
              for (var i = 0; i < countArr; i++) {
                var default_tr = '<tr  class="clone_tr">'+
                '<td class="alignRight">'+'<input class="hier_add key_event" name="hier[]" value = "" type="text" id=""　	>'+'</td>' +
                '<td class="alignRight">'+'<input class="title_add" name="title[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="standard_add" name="standard[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="quantity_add" name="input_quantity[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="unit_add" name="unit[]" type="text" value = "" >'+'</td>'+
                '<td class="alignRight">'+'<input class="price_add" name="input_price[]" value = "" type="text" >'+'</td>'+
                '<td class="alignRight">'+'<input class="bugakari_add" name="input_bugakari[]" value = "" type="text">'+'</td>'+
                '<td class="alignRight" class = "unit-price">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'</td>'+
                '<td class="alignRight">'+'<textarea class="remark" rows="2" cols="30" name="input_remark[]" id="edit_row">'+'</textarea>'+'</td>'+
                '<input type ="hidden" value=""name = "hidden_id[]">'+
                '</tr>';
                $('#tree').append(default_tr);
                $('.hier_add').attr('class','hier' + i);
                $('.hier'+i).addClass('key_event');
                $('.title_add').attr('class','title' + i);
                $('.standard_add').attr('class','standard' + i);
                $('.quantity_add').attr('class','quantity' + i);
                $('.unit_add').attr('class','unit' + i);
                $('.price_add').attr('class','price' + i);
                $('.bugakari_add').attr('class','bugakari' + i);
                if (i<leng) {
                  $('.clone_tr').find('.hier' +i).val(data1[i][0]);
                  $('.clone_tr').find('.title' +i).val(data1[i][1]);
                  $('.clone_tr').find('.standard'+i).val(data1[i][2]);
                  $('.clone_tr').find('.quantity'+i).val(data1[i][3]);
                  $('.clone_tr').find('.unit'+i).val(data1[i][4]);
                  $('.clone_tr').find('.price'+i).val(data1[i][5]);
                  $('.clone_tr').find('.bugakari'+i).val(data1[i][6]);
                  $('.hier'+i).removeClass('hier'+i);
                  $('.title'+i).removeClass('title'+i);
                  $('.standard'+i).removeClass('standard'+i);
                  $('.quantity'+i).removeClass('quantity'+i);
                  $('.unit'+i).removeClass('unit'+i);
                  $('.price'+i).removeClass('price'+i);
                  $('.bugakari'+i).removeClass('bugakari'+i);
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
          $('#tree').change(function() {

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
            console.log(Object.entries(object));
            $('#quotation_data').val(Object.entries(object));
            //バリデーション
            //見積もり日付
            if ($("[name=quote_year]").val() == ""　|| $("[name=quote_month]").val() == "" || $("[name=quote_day]").val() == "") {
              alert('見積日付を入力してください。');
              return;
            }
            //担当者
            if ($("[name=staffs]").val() == "") {
              alert('担当者を選択してください。');
              return;
            }
            //得意先
            if ($("[name=customer-name]").val() == "") {
              alert('得意先を選択してください。');
              return;
            }
            //物件名
            if ($("[name=quote-title]").val() == "") {
              alert('物件名を入力してください。');
              return;
            }
            //工事場所
            if ($("[name=place]").val() == "") {
              alert('工事場所を入力してください。');
              return;
            }
            //御支払条件
            if ($("[name=payment_term]").val() == "") {
              alert('御支払条件所を入力してください。');
              return;
            }
            //有効期限
            if ($("[name=expiration_date]").val() == "") {
              alert('有効期限を入力してください。');
              return;
            }
            //工期
            if($("[name=period_before_year]").val() == ""　|| $("[name=period_before_month]").val() == "" || $("[name=period_before_day]").val() == "") {
              alert('工期を入力してください。');
              return;
            }
            if($("[name=period_after_year]").val() == ""　|| $("[name=period_after_month]").val() == "" || $("[name=period_after_day]").val() == "") {
              alert('工期を入力してください。');
              return;
            }

            $("#quotationDetails_form").submit();
          });
        }

        $(function(){
          var d=[];
          var subtotal = 0;
          var totalProfit = 0;
          const tax_rate = 0.1;

          $('#tree .clone_tr').each(function(i, e){
            var dd=[];
            $(this).find('td').each(function(j, el){
              dd.push($(this).text())
            });
            d.push(dd);
            var price = d[i][5];
            var bugakari = d[i][6];
            var quantity = d[i][3];
            //単価
            var unitPrice = parseInt(price) * (parseInt(bugakari) +100) / 100;
            //原価
            var cost = parseInt(quantity) * parseInt(price);
            //見積もり
            var subtotalEstimate = unitPrice * quantity;
            //利益
            var profit = subtotalEstimate - cost;
            //各行の計算
            //単価
            if (!isNaN(unitPrice)) {
              $('#tree tr').eq(i+1).children('td').eq(7).text(unitPrice);
            }
            //原価
            if (!isNaN(cost)) {
              $('#tree tr').eq(i+1).children('td').eq(8).text(cost);
            }
            //見積もり
            if (!isNaN(subtotalEstimate)) {
              $('#tree tr').eq(i+1).children('td').eq(9).text(subtotalEstimate);
            }
            //利益
            if (!isNaN(profit)) {
              $('#tree tr').eq(i+1).children('td').eq(10).text(profit);
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
          });
        });
        window.onpageshow = function(event) {
          if (event.persisted) {
            window.location.reload();
          }
        };
