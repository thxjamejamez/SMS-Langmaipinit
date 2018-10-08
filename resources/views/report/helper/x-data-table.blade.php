<!-- template for the DataTable component -->
<template id="x-data-table">
        <div class="x-data-table">
      
          <div class="x-order d-flex">
            <div class="x-length d-flex" v-if="filterLength.length">
              <label for>Show:</label>
              <select class="form-control" v-model="showAoe" @change="changePage(1)">
                <option v-for="(valve, key) in filterLength"
                  :key="key"
                  :value="valve">
                  @{{ valve }}
                </option>
              </select>
      
              <slot name="x-other"></slot>
            </div>
      
            <div class="x-search d-flex">
              <label for>Search:</label>
              <input required
                type="text"
                class="form-control"
                v-model="search"
                @keyup="changePage(1)"
                @keyup.enter="$emit('search', search)"
              />
            </div>
          </div>
      
          <table class="x-table">
            <thead>
              <tr>
                <th v-for="(column, key) in columns" :key="key"
                  :class="{focus: sortKey == column.key}"
                  @click="sortBy(column.key)">
                  @{{ column.label | capitalize }}
                  <span class="arrow" :class="sortOrders[column.key] > 0 ? 'asc' : 'dsc'"></span>
                </th>
              </tr>
            </thead>
      
            <tbody>
              <tr v-for="(item, key) in dataStore" :key="key">
                <td v-for="(column, key) in columns"
                  :key="key"
                  :class="column.class"
                  :style="[column.style, item.style]"
                  v-html="marker(item[column.key])"
                  @click="column.click ? $emit('choose',item ) : false">
                </td>
              </tr>
              <tr v-if="sum">
                <td :colspan="columns.length-1"
                  style="background-color: #cce4cc"><b>SUM</b></td>
                <td style="background-color: #cce4cc; text-align: right"><b>@{{ sum }}</b></td>
              </tr>
            </tbody>
          </table>
      
          <div class="x-entry d-flex">
            <span class="x-showing">
              Showing <b>@{{ showy.from }}</b> to <b>@{{ showy.from + dataStore.length }}</b>
              of <b>@{{ showy.all }}</b> entries.
            </span>
      
            <ul class="x-paging">
              <li :disabled="currentPage === 1"
                @click="changePage(currentPage - 1)">
                Previos
              </li>
      
              <li :class="{'focus': currentPage === 1}"
                @click="changePage(1)">
                1
              </li>
              <li v-if="pages > 4 && (currentPage - 1) > 2" class="dot">...</li>
              <li v-for="(page, key) in pages"
                v-if="key < (currentPage + 1)
                  && key > (currentPage - 3)
                  && key > 0
                  && key < (pages - 1)"
                :key="key"
                :class="{'focus': page === currentPage}"
                @click="changePage(page)">
                @{{ page }}
              </li>
              <li v-if="pages > 4 && (currentPage + 2) < pages" class="dot">...</li>
              <li v-if="pages > 1"
                :class="{'focus': currentPage === pages}"
                @click="changePage(pages)">
                @{{ pages }}
              </li>
      
              <li :disabled="currentPage === pages"
                @click="changePage(currentPage + 1)">
                Next
              </li>
            </ul>
          </div>
        </div>
      </template>
      
      
      {{-- ###################################################################### --}}
      {{-- ########################## Javascript Scope ########################## --}}
      <script>
      const x__dataTable__x = {
        template: '#x-data-table',
      
        props: {
          data: {
            type: [Object, Array],
            required: false,
            default: function () {
              return [
                { _name: 'Basilisk\'s', _power: 99999 },
                { _name: '<a>Lycan\'s</a>', _power: 88888 },
              ]
            }
          },
      
          columns: {
            type: [Object, Array],
            required: false,
            default: function () {
              return [
                { key: '_name', label: 'name' },
                { key: '_power', label: 'power' }
              ]
            }
          },
          
          sum: {
            type: String,
            required: false,
            default: ''
          },
      
          sortKey: {
            type: String,
            required: false,
            default: ''
          },
      
          sortLength: {
            type: Number,
            required: false,
            default: 10
          },
      
          filterLength: {
            type: Array,
            required: false,
            default: function () {
              return [5, 10, 25, 50, 100]
            }
          }
        },
      
        data: function () {
          let sortOrders = {}
          this.columns.forEach(function (column) { sortOrders[column.key] = 1 })
          return {
            currentPage   : 1,
            sortOrders    : sortOrders,
            sortCol       : this.sortKey,
            search        : null,
            showAoe       : this.sortLength
          }
        },
      
        computed: {
          dataStore: function () {
            const $vm = this
            const sortCol     = this.sortCol
            const sortLength  = this.showAoe
            const SEARCH      = this.search && this.search.toLowerCase()
            const order       = this.sortOrders[sortCol] || 1
            const column      = this.columns
            let DATA          = Object.assign([], this.data)
      
            if (SEARCH) {
              DATA = DATA.filter(function (row) {
                return Object.keys(row).some(function (key) {
                  let col = column.find(function (h) {return h.key === key})
                  if (col !== undefined)
                    return String(row[key]).toLowerCase().indexOf(SEARCH) > -1
                })
              })
            }
      
          columnSelect = _.find(column, function(o) { return o.key == sortCol});
          
            if (sortCol) {
              if(columnSelect.customSort){
                    sortType = columnSelect.customSort.sortType
                    sortKey  = columnSelect.customSort.sortKey
                    DATA = _.sortBy(DATA,function(item){return new Date(item[sortKey]) })
                    if(order == 1)DATA.reverse()
              }else{
                DATA = DATA.slice().sort(function (a, b) {
                  a = $vm.stripTags(a[sortCol])
                  b = $vm.stripTags(b[sortCol])
                  return (a === b ? 0 : a > b ? 1 : -1) * order
                })
              }
            }
      
            const _lastData = []
            const current   = ((sortLength * this.currentPage + 1) - sortLength)
            for (var i = current; i <= (sortLength * this.currentPage) && i <= DATA.length; i++) {
              _lastData.push(DATA[i - 1])
            }
      
            return _lastData
          },
      
          pages: function () {
            let a = this.data.length
            let b = this.showAoe
            return (a % b > 0 ? 1 : 0) + parseInt(a / b)
          },
      
          showy: function () {
            let a = this.showAoe
            let b = this.currentPage
            let c = this.data.length
      
            return {
              from: b === 1 ? 1 : ((a * b + 1) - a),
              to: (a * b) > c ? c : (a * b),
              all: c
            }
          }
        },
      
        filters: {
          capitalize: function (str) {
            return str.charAt(0).toUpperCase() + str.slice(1)
          }
        },
      
        methods: {
          sortBy: function (key) {
            // this.changePage(1)
            this.sortCol = key
            this.sortOrders[key] = this.sortOrders[key] * -1
          },
      
          changePage: function (page) {
            if (this.currentPage !== page && page > 0) {
              this.currentPage = page
            }
          },
      
          marker: function (str) {
            const tags   = /(<([^>]+)>)/ig.test(str)
            let search   = this.search
            let valve    = str
      
            if (tags) {
              var seed = str
              str = this.stripTags(str)
            }
      
            if (search) {
              valve = String(str).replace(new RegExp(search, 'gi'), function (match) {
                return '<span class=x-light>'+ match +'</span>'
              })
            }
      
            if (tags && search) {
              valve = seed.replace('>'+ str, '>'+ valve)
            }
      
            return valve
          },
      
          stripTags: function (valve) {
            const html = /(<([^>]+)>)/ig
      
            if (html.test(valve)) valve = valve.replace(html, '')
      
            return /\D+/g.test(valve)
              ? /\d\,\d/g.test(valve)
                ? parseInt(valve.replace(',', ''))
                : valve
              : parseInt(valve)
          },
      
          pusher: function (valve) {
            if ('object' == typeof valve) {
              this.data = valve
              this.changePage(1)
              this.search = null
            } else {
              console.error('[Object] is required.')
            }
          }
        }
      }
      
      const XTable = function () {
        return x__dataTable__x
      }
      Vue.component('data-table',
        x__dataTable__x
      )
      </script>
      
      
      {{-- ###################################################################### --}}
      {{-- ############################## CSS Scope ############################# --}}
      <style type="text/css">
      .x-data-table {
        position: relative;
        padding: 10px 0 0;
        /* border-top: solid 1px #eee; */
      }
      .x-data-table .x-order {
        margin: 0 0 7px;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }
        .x-order label {
          margin: 0 5px 0 0;
        }
        .x-order .x-search input {
          min-width: 220px;
        }
        .x-order .form-control {
          height: auto;
          padding: 5px 10px;
        }
        .x-order .form-control:focus { border-color: #d2d6de }
      
      .x-data-table .x-table {
        background-color: white;
        width: 100%;
        border-spacing: 2px;
        border-collapse: separate;
        border: 2px solid #343a40;
      }
        .x-table thead {
          cursor: pointer;
          color: hsla(0, 0%, 100%, .8);
          background-color: #343a40;
        }
        .x-table thead th {
          white-space: nowrap;
          position: relative;
          font-size: 15px;
          padding: 10px 30px 10px 15px;
          -webkit-user-select: none;
             -moz-user-select: none;
              -ms-user-select: none;
                  user-select: none;
        }
        .x-table thead th.focus { color: white }
        .x-table thead th.focus .arrow { opacity: 1 }
      
        .x-table tbody td {
          padding: 7px 15px;
        }
        .x-table tbody td a {
          cursor: pointer;
        }
        .x-table tbody td.desc {
          white-space: pre-wrap;
        }
        .x-table tbody td .x-light {
          background-color: #ff0;
        }
        .x-table tbody > tr:nth-of-type(odd) {
          background-color: #f9f9f9;
        }
        .x-table tbody > tr:hover > td {
          background-color: hsla(153, 47%, 49%, .15);
        }
      
        .x-table thead .arrow {
          position: absolute;
          top: 40%;
          right: 10px;
          opacity: .72;
        }
        .x-table thead .arrow.asc,
        .x-table thead .arrow.dsc {
          border-left:  5px solid transparent;
          border-right: 5px solid transparent;
        }
        .x-table thead .arrow.asc { border-bottom: 5px solid white }
        .x-table thead .arrow.dsc { border-top: 5px solid white }
      
      
      .x-data-table .x-entry {
        margin: 10px 0 0;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }
        .x-entry .x-showing {}
      
        .x-entry .x-paging {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }
        .x-entry .x-paging > li {
          position: relative;
          cursor: pointer;
          font-size: 12px;
          padding: 3px 12px;
          border-top: solid 1px #eee;
          border-right: solid 1px #eee;
          border-bottom: solid 1px #eee;
      
          -webkit-user-select: none;
             -moz-user-select: none;
              -ms-user-select: none;
                  user-select: none;
        }
        .x-entry .x-paging > li.focus {
          color: white;
          border-color: #42b883;
          background-color: #42b883;
        }
        .x-entry .x-paging > li:not(.focus):hover {
          background-color: #f9f9f9;
        }
        .x-entry .x-paging > li[disabled] {
          color: #999;
          pointer-events: none;
        }
        .x-entry .x-paging > li.dot { pointer-events: none }
        .x-entry .x-paging > li:first-child {
          border-left: solid 1px #eee;
          border-top-left-radius: 2px;
          border-bottom-left-radius: 2px;
        }
        .x-entry .x-paging > li:last-child {
          border-bottom-right-radius: 2px;
          border-bottom-right-radius: 2px;
        }
      
      .d-flex {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
      
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
      }
      </style>
      