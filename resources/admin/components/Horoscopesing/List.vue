<template>
  <div>
    <v-card-title>
      Week Horoscope
      <v-btn
        class="mx-2"
        fab
        dark
        small
        color="primary"
        @click.prevent="newWeekInfoDialog = true"
      >
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
      <div class="flex-grow-1"></div>
    </v-card-title>
    <v-card-title>
      <div class="d-inline" style="font-size: 14px">
        <input
          type="checkbox"
          v-model="filter.archived"
          @click="checkSearch()"
        />
        <label for="checkbox">Include Archived</label>
      </div>
      <div class="flex-grow-1"></div>

      <div class="d-inline" style="font-size: 14px">
        <v-select
          v-model="filter.sign"
          :items="horoscope_all"
          label="Filter By Sign"
          item-text="name"
          item-value="id"
          background-color="#F0F0F7"
          multiple
          filled
          dense
          solo
          height="35"
          selectSlot="true"
          append-icon="ico-sort-arrows"
          class="widthSelect float-right"
          :menu-props="{ contentClass: 'checkListGray' }"
          @change="filterSearch"
        >
          <template v-slot:selection="{ item, index }">
            <div v-if="filter.sign.length <= 1" class>{{ item.name }}</div>
            <span v-if="index === 1">Show Filtered</span>
          </template>
        </v-select>


         <v-select
          v-model="filter.week"
          :items="weeks"
          label="Filter By week"
          item-text="name"
          item-value="idweek"
          background-color="#F0F0F7"
          multiple
          filled
          dense
          solo
          height="35"
          selectSlot="true"
          append-icon="ico-sort-arrows"
          class="widthSelect widthSelectWeek float-right mr-5"
          :menu-props="{ contentClass: 'checkListGray' }"
          @change="filterSearch"
        >
          <template v-slot:selection="{ item, index }">
            <div v-if="filter.week.length <= 1" class>{{ item.name }}</div>
            <span v-if="index === 1">Show Filtered</span>
          </template>
        </v-select>
      </div>
    </v-card-title>

    <v-data-table
      v-if="horoscopesign.length"
      :headers="[
        { text: 'Archive Entry', value: 'check' },
        { text: 'Signs', align: 'left', value: 'horoscope_name.name' },
        { text: 'Start_Week', align: 'left', value: 'start_week' },
        { text: 'End_Week', align: 'left', value: 'end_week' },
        { text: 'Match1', align: 'left', value: 'match1.name' },
        { text: '', align: 'left', value: 'subject1' },
        { text: 'Match2', align: 'left', value: 'match2.name' },
        { text: '', align: 'left', value: 'subject2' },
        { text: 'Match3', align: 'left', value: 'match3.name' },
        { text: '', align: 'left', value: 'subject3' },
        { text: 'hustle', align: 'left', value: 'hustle' },
        { text: 'love', align: 'left', value: 'love' },
        { text: 'outlook', align: 'left', value: 'outlook' },
        { text: 'vibe', align: 'left', value: 'vibe' },
        { text: 'content', align: 'left', value: 'content' },
        { value: 'actions' },
      ]"
      :items="horoscopesign"
      class="elevation-1"
      disable-pagination
      hide-default-footer
    >
      <template v-slot:item.name="props">
        <v-edit-dialog
          :return-value.sync="name"
          @save="save(props.item)"
          @open="name = props.item.name"
        >
          {{ props.item.name }}
          <template v-slot:input>
            <v-text-field
              v-model="name"
              label="Edit"
              single-line
              counter
            ></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.description="props">
        <v-edit-dialog
          :return-value.sync="description"
          @save="saveDescription(props.item)"
          @open="description = props.item.description"
        >
          {{ props.item.description }}
          <template v-slot:input>
            <v-text-field
              v-model="description"
              label="Edit"
              single-line
              counter
            ></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.users_count="props">
        {{ props.item.users_count }}
      </template>

      <template v-slot:item.check="props">
        <input
          type="checkbox"
          v-model="props.item.archived"
          @click="archiveItem(props.item)"
        />
      </template>

      <template v-slot:item.actions="props">
        <v-btn icon @click.prevent="editItem = props.item">
          <v-icon color="teal" class="mr-2">mdi-pencil</v-icon>
        </v-btn>

        <v-btn icon @click="deleteItem(props.item)">
          <v-icon color="red" class="mr-2">mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>


    <v-dialog v-model="newWeekInfoDialog" width="750" id="newWeekInfoDialog">
      <v-card>
        <v-card-text class="p-0">
          <form method="POST" action class="week_horoscope_form">
            <div class="row">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                <div class="text-center">
                  <h2>{{ newHoroscope.id ? "Edit" : "Create" }}  Week Horoscope Info</h2>
                  <v-icon
                    class="text-right"
                    style="float: right; top: -26px"
                    @click="newWeekInfoDialog = false"
                    >mdi-close</v-icon
                  >
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                <label class="control-label">
                  Horoscope Zodiac
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.horoscope_zodiac_signs_id"
                  required
                >
                  
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>

                <span
                  v-if="errors.horoscope_zodiac_signs_id"
                  class="float-left text-danger"
                  >{{ errors.horoscope_zodiac_signs_id[0] }}</span
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Start Week
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-mask="'##/##/####'"
                  v-model="newHoroscope.start_week"
                  placeholder="00/00/0000"
                />
                <span v-if="errors.start_week" class="float-left text-danger">{{
                  errors.start_week[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  End Week
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  type="text"
                  required
                  v-mask="'##/##/####'"
                  v-model="newHoroscope.end_week"
                  placeholder="00/00/0000"
                />
                <span v-if="errors.end_week" class="float-left text-danger">{{
                  errors.end_week[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 1
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.match_id1"
                >
                  
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match1" class="float-left text-danger">{{
                  errors.match1[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="newHoroscope.subject1"
                  placeholder=""
                />
                <span v-if="errors.subject1" class="float-left text-danger">{{
                  errors.subject1[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 2
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.match_id2"
                >
                  
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match2" class="float-left text-danger">{{
                  errors.match2[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="newHoroscope.subject2"
                  placeholder=""
                />
                <span v-if="errors.subject2" class="float-left text-danger">{{
                  errors.subject2[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 3
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.match_id3"
                >
                  
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match3" class="float-left text-danger">{{
                  errors.match3[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="newHoroscope.subject3"
                  placeholder=""
                />
                <span v-if="errors.subject3" class="float-left text-danger">{{
                  errors.subject3[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Hustle
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.hustle"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>

                <span v-if="errors.hustle" class="float-left text-danger">{{
                  errors.hustle[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Love
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.love"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.love" class="float-left text-danger">{{
                  errors.love[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Outlook
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.outlook"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.hustle" class="float-left text-danger">{{
                  errors.outlook[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Vibe
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="newHoroscope.vibe"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.vibe" class="float-left text-danger">{{
                  errors.vibe[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                <label class="control-label">
                  Content
                  <span class="text-danger">*</span>
                </label>

                <v-textarea
                  v-model="newHoroscope.content"
                  class="form-control"
                  required
                  outlined
                  name="input-7-5"
                  label="Description"
                ></v-textarea>

                <span v-if="errors.content" class="float-left text-danger">{{
                  errors.content[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-1 mt-5">
              <div class="col-12 text-center">
                <v-btn
                  class
                  large
                  color="primary"
                  rounded
                  min-width="70"
                  :loading="loading"
                  :disabled="loading"
                  @click="registerHoroscopesInfo()"
                  >Save</v-btn
                >
              </div>
            </div>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>



    <v-dialog v-model="dialog" width="750" id="editItem">
      <v-card>
        <v-card-text class="p-0">
          <form method="POST" action class="week_horoscope_form">
            <div class="row">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                <div class="text-center">
                  <h2>
                    {{ editItem.id ? "Edit" : "Create" }} Week Horoscope Info
                  </h2>
                  <v-icon
                    class="text-right"
                    style="float: right; top: -26px"
                    @click="dialog = false"
                    >mdi-close</v-icon
                  >
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                <label class="control-label">
                  Horoscope Zodiac
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.horoscope_zodiac_signs_id"
                  required
                >
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>

                <span
                  v-if="errors.horoscope_zodiac_signs_id"
                  class="float-left text-danger"
                  >{{ errors.horoscope_zodiac_signs_id[0] }}</span
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Start Week
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-mask="'##/##/####'"
                  v-model="editItem.start_week"
                  placeholder="00/00/0000"
                />
                <span v-if="errors.start_week" class="float-left text-danger">{{
                  errors.start_week[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  End Week
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  type="text"
                  required
                  v-mask="'##/##/####'"
                  v-model="editItem.end_week"
                  placeholder="00/00/0000"
                />
                <span v-if="errors.end_week" class="float-left text-danger">{{
                  errors.end_week[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 1
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.match_id1"
                >
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match1" class="float-left text-danger">{{
                  errors.match1[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="editItem.subject1"
                  placeholder=""
                />
                <span v-if="errors.subject1" class="float-left text-danger">{{
                  errors.subject1[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 2
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.match_id2"
                >
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match2" class="float-left text-danger">{{
                  errors.match2[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="editItem.subject2"
                  placeholder=""
                />
                <span v-if="errors.subject2" class="float-left text-danger">{{
                  errors.subject2[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Match 3
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.match_id3"
                >
                  <option
                    v-for="horoscope in horoscope_all"
                    :key="horoscope.id"
                    :value="horoscope.id"
                  >
                    {{ horoscope.name }}
                  </option>
                </select>
                <span v-if="errors.match3" class="float-left text-danger">{{
                  errors.match3[0]
                }}</span>
              </div>

              <div class="col-md-6 col-6 col-sm-6 col-lg-6 mb-3">
                <label class="control-label">
                  Subject
                  <span class="text-danger">*</span>
                </label>
                <input
                  class="form-control"
                  required
                  type="text"
                  v-model="editItem.subject3"
                  placeholder=""
                />
                <span v-if="errors.subject3" class="float-left text-danger">{{
                  errors.subject3[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Hustle
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.hustle"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>

                <span v-if="errors.hustle" class="float-left text-danger">{{
                  errors.hustle[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Love
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.love"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.love" class="float-left text-danger">{{
                  errors.love[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Outlook
                  <span class="text-danger">*</span>
                </label>
                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.outlook"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.hustle" class="float-left text-danger">{{
                  errors.outlook[0]
                }}</span>
              </div>
              <div class="col-md-3 col-3 col-sm-3 col-lg-3 mb-3">
                <label class="control-label">
                  Vibe
                  <span class="text-danger">*</span>
                </label>

                <select
                  class="form-control"
                  style="-webkit-appearance: button"
                  v-model="editItem.vibe"
                >
                  <option
                    v-for="percentage in percentages"
                    :key="percentage"
                    :value="percentage"
                  >
                    {{ percentage }}%
                  </option>
                </select>
                <span v-if="errors.vibe" class="float-left text-danger">{{
                  errors.vibe[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                <label class="control-label">
                  Content
                  <span class="text-danger">*</span>
                </label>

                <v-textarea
                  v-model="editItem.content"
                  class="form-control"
                  required
                  outlined
                  name="input-7-5"
                  label="Description"
                ></v-textarea>

                <span v-if="errors.content" class="float-left text-danger">{{
                  errors.content[0]
                }}</span>
              </div>
            </div>

            <div class="row mb-1 mt-5">
              <div class="col-12 text-center">
                <v-btn
                  class
                  large
                  color="primary"
                  rounded
                  min-width="70"
                  :loading="loading"
                  :disabled="loading"
                  @click="updateItem()"
                  >Save</v-btn
                >
              </div>
            </div>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      dialog: false,
      checkbox: true,
      filter: {
        archived: false,
        sign: "",
        week: "",
      },
      item: null,
      store: "horoscopesign",
      horoscope_all: [],
      errors: [],
      loading: false,
      percentages: [
        "10",
        "20",
        "30",
        "40",
        "50",
        "60",
        "70",
        "80",
        "90",
        "100",
      ],
      editItem: {},
         newHoroscope: {
        horoscope_zodiac_signs_id :  "",
        start_week : "",
        end_week : "",
        match_id1 :  "",
        subject1 : "",
        match_id2 :  "",
        subject2 : "",
        match_id3 :  "",
        subject3 : "",
        content : "",
        hustle :  "",
        love :  "",
        outlook :  "",
        vibe :  "",
      },
      newWeekInfoDialog: false,
      
    };
  },

  methods: {
    async getHoroscope() {
      await this.$store
        .dispatch(this.store + "/getHoroscope")
        .then((response) => {
          this.horoscope_all = response;
        });
    },

    async deleteItem(item) {
      if (confirm("Are you sure want to delete ++" + item.id)) {
        await this.$store
          .dispatch(this.store + "/delete", { id: item.id })
          .then((response) => {
            if (response.data == "ok")
              this.$store.dispatch(this.store + "/getItems", this.filter);
            this.item = null;
          });
      }
    },
   resetHoroscope() {
      this.newHoroscope = {
        horoscope_zodiac_signs_id :  "",
        start_week : "",
        end_week : "",
        match_id1 :  "",
        subject1 : "",
        match_id2 :  "",
        subject2 : "",
        match_id3 :  "",
        subject3 : "",
        content : "",
        hustle :  "",
        love :  "",
        outlook :  "",
        vibe :  "",
      };
    },

    registerHoroscopesInfo() {
      this.loading = true;
      var input = this.newHoroscope;
      axios
        .post("/api/agency/horoscopeinfo/save", input)
        .then((res) => {
          if (res.status == 200) {
            //Created
            this.$store.dispatch(this.store + "/getItems", this.filter);
            this.newWeekInfoDialog = false;

            this.resetHoroscope();
            // this.messagresetHoroscopeeDialog = true;
          }
          this.loading = false;
          this.errors = [];
        })
        .catch(error => {
          this.loading = false;
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            if (error.response.status === 400) {
              this.message = error.response.data.message;
            } else {
              this.message =
                "Your payment method could not be added. " +
                error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR"
            });
          }
        });
    },

    filterSearch() {
      this.$store.dispatch(this.store + "/getItems", this.filter);
    },
    checkSearch() {
      if (this.filter.archived == 0) this.filter.archived = 1;
      else this.filter.archived = 0;
      this.$store.dispatch(this.store + "/getItems", this.filter);
    },
    archiveItem(item) {
      this.loading = true;
      axios.post("/api/agency/archive-horoscopeinfo", item).then((response) => {
        if (response.status == 200) {
          this.$store.dispatch(this.store + "/getItems", this.filter);
        }
      });
    },

    updateItem() {
      this.loading = true;
      var input = this.editItem;
      axios
        .post("/api/agency/horoscopeinfo/update", input)
        .then((res) => {
          if (res.status == 200) {
            //Created

            console.log(res);
            this.$store.dispatch(this.store + "/getItems", this.filter);
            this.dialog = false;

            // this.resetHoroscope();
            // this.messagresetHoroscopeeDialog = true;
          }
          this.loading = false;
          this.errors = [];
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            if (error.response.status === 400) {
              this.message = error.response.data.message;
            } else {
              this.message =
                "Your payment method could not be added. " +
                error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          }
        });
    },
  },
  watch: {
    editItem(val) {
      if (val.id) this.dialog = true;
    },
    dialog(val) {
      if (!val) this.editItem = {};
    },
  },
  computed: {
    ...mapGetters({
      horoscopesign: "horoscopesign/items",
      weeks: "horoscopesign/weeks",
    }),
  },

  created() {
    this.getHoroscope();
    this.$store.dispatch(this.store + "/getWeeks", this.filter);
    this.$store.dispatch(this.store + "/getItems", this.filter);
  },
};
</script>
<style>

#newWeekInfoDialog {
  background: rgb(244, 244, 244);
  border-radius: 30px !important;
}


.week_horoscope_form .text-danger{
    color:red  !important;
    font-weight: 500 !important;
    font-size: 10px;
}
.week_horoscope_form .form-control {
  width: 100%;
  border: 1px solid rgb(90, 89, 89);
  border-radius: 5px !important;
}
.week_horoscope_form label {
  font-size: 12px;
  font-weight: 600 !important;
  color: rgb(162, 162, 162) !important;
}


.v-data-table td.v-data-table__mobile-row:first-child {
  height: 90px;
}

.widthSelect {
  width: 170px !important;
  font-size: 12px  !important;
}


.widthSelectWeek {
  width: 200px !important;
}

.v-application--is-ltr .checkListGray .v-list-item__action:first-child,
.v-application--is-ltr .checkListGray .v-list-item__icon:first-child {
  margin-right: 10px !important;
}

.ico-sort-arrows {
  content: url("/images/icons/sort.svg");
  right: -2px !important;
}
.checkListGray .v-list-item {
  border-bottom: none !important;
  background: #f0f0f7 !important;
  color: #8e8d99 !important;
  padding: 0px 7px !important;
}

.checkListGray.v-menu__content .theme--light.v-list-item--active {
  border-bottom: 1px solid #f0f0f7 !important;
  background: #f0f0f7 !important;
  color: #8e8d99 !important;
}

.checkListGray .v-text-field input,
.widthSelect .v-label,
.checkListGray .v-label,
.widthSelect span,
.checkListGray span,
.widthSelect .v-text-field input {
  font-size: 12px;
}
</style>