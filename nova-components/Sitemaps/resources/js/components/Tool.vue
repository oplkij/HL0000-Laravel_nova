<template>
    <div>
        <heading class="mb-6">Site Maps</heading>

        <card class="flex flex-col items-baseline" style="min-height: 600px; background-image:url('/images/bg.jpg');" ref="card">
          
            <img draggable="false" class="black-hole" src="images/black-hole.png">
  
            <img draggable="true" class="placeholder" @dragstart='addDrag($event)' src="images/placeholder.png">

            <div ref="map">
                <img draggable="false"  @drop='drop($event)' @dragover='allowDrop($event)' src="images/floorplan_layout.png">   
            </div>

            <!-- <el-button @click="addPoint" type="primary">Add New item</el-button> -->

            <!-- :x="Number(point.coordinate[0].x) *(map.width / 645)" 
            :y="Number(point.coordinate[0].y) *(map.height / 521)" -->

            <VueDragResize v-for="point in points" v-bind:key="point.id" 
                :parentLimitation="true" 
                :w="35" :h="50" 
                :x="Number(point.coordinate[0].x)" 
                :y="Number(point.coordinate[0].y)" 
                :isResizable="false"
                @clicked="onClicked(point.id)"  
                @dragging="onDragging"
                @dragstop="onDragstop">      
              
                <el-button @click="getPageview()" type="text" style="color:#ffffff">
                    <i class="el-icon-location" style=" font-size: 32px; color: red;" v-if="point.status === 'Active'"></i>
                    <i class="el-icon-location" style=" font-size: 32px; color: gray;" v-else></i>
                    <span v-if="point.name.length<9"> {{ point.name }}</span>
                    <span v-else> {{ point.name.substring(0,8)+"..." }}</span>
                </el-button>
            </VueDragResize>

            <!-- Form -->
            <div id="parentx">      
                <vs-sidebar position-right parent="body" default-index="1" color="primary" class="sidebarx" spacer v-model="active">

                    <div class="header-sidebar" slot="header">
                        <!-- <vs-avatar  size="70px" src="https://randomuser.me/api/portraits/men/85.jpg"/> -->

                        <h4>
                            ID: {{facilities.id}}
                        </h4>

                    </div>

                    <el-form :model="facilities" :rules="rules" ref="ruleForm" label-width="100px">
                        <!-- Name -->                        
                        <el-form-item label="Name" prop="name">
                            <el-input v-model="facilities.name" placeholder="Name"></el-input>
                        </el-form-item>

                        <!-- Type -->
                        <el-form-item label="Type" prop="type">
                            <el-select v-model="facilities.type" placeholder="Type">
                                <el-option label="Toilet" value="toilet"></el-option>
                                <el-option label="Shop" value="shop"></el-option>
                                <el-option label="Disabled Toilet" value="disabled_toilet"></el-option>
                                <el-option label="Emergency Exit" value="exit"></el-option>
                            </el-select>
                        </el-form-item>

                        <!-- Description -->
                        <el-form-item label="Description" prop="description">
                            <el-input type="textarea" v-model="facilities.description"></el-input>
                        </el-form-item>

                        <!-- Open Hour -->
                        <el-form-item label="Open Hour" prop="open_hour">
                            <el-time-picker
                                is-range
                                v-model="facilities.open_hour"                             
                                start-placeholder="Start Time"
                                end-placeholder="End Time"
                                placeholder="Please select the rang">
                            </el-time-picker>
                        </el-form-item>

                        <!-- Location -->
                        <el-form-item label="Location" prop="location">
                            <el-input type="textarea" v-model="facilities.location"></el-input>
                        </el-form-item>

                        <!-- Thumbnail -->
                        <el-form-item label="Thumbnail" prop="thumbnail">               
                            <!-- <vs-upload multiple automatic text="Upload Multiple" action="/photo/" @change="onUpload" @on-delete="deleteUpload"/> -->
                            <el-upload
                                action="photo/"
                                list-type="picture-card"
                                :on-change="handleChange"
                                :on-preview="handlePictureCardPreview"
                                :on-remove="handleRemove"       
                                
                                multiple    
                                :file-list="facilities.thumbnail">
                                <i class="el-icon-plus"></i>
                            </el-upload>
                        </el-form-item>

                        <!-- Status -->                   
                        <el-form-item label="Status" prop="status">
                            <el-radio-group v-model="facilities.status" size="medium">
                                <el-radio-button label="Active"></el-radio-button>
                                <el-radio-button label="Disabled"></el-radio-button>
                                <el-radio-button label="Maintenance"></el-radio-button>
                            </el-radio-group>
                        </el-form-item>
                        
                        <el-form-item>
                            <el-button type="primary" @click="submitForm('ruleForm')">Submit</el-button>
                            <el-button @click="resetForm()">Reset</el-button>
                        </el-form-item>
                    </el-form>

                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>

                </vs-sidebar>
            </div>
           
        </card>
    </div>
</template>

<script>
import axios from 'axios';
import VueDragResize from 'vue-drag-resize';
import { verify } from 'crypto';

export default {
    components: {
        VueDragResize
    },

    data:()=>({
        active:false,
        counterDanger: true,
        isChangedImage: false,
        startDrag: false,
        changeID: false,

        //form value
        facilities:{
            id:'',
            name:'',
            type:'',
            description:'',
            open_hour:[],
            location:'',
            thumbnail:[],
            coordinate:[],
            status:'Active',
        },

        //form rules
        rules: {
            name: [
            { required: true, message: 'Please input the name', trigger: 'blur' },
            { min: 1, max: 40, message: 'Max 40 character', trigger: 'blur' }
            ],
            type: [
            { required: true, message: 'Please select the type', trigger: 'change' }
            ],
            description: [
            { required: true, message: 'Please input the description', trigger: 'blur' }
            ],
            open_hour: [
            { required: true, message: 'Please select the open hour', trigger: 'change' }
            ],
            location: [
            { required: true, message: 'Please input the location', trigger: 'blur' }
            ],         
            status: [
            { required: true, message: 'Please select the status', trigger: 'change' }
            ],
        },

        //all point
        points:[],
        
        //point position
        card:{
            width: 0,
            height: 0
        },

        map:{
            width: 645,
            height: 521
        },
       
        top: 0,
        left: 0,

        //thumbnail group
        fileList:[],

        //thumbnail div
        dialogImageUrl: '',
        dialogVisible: false,
    }),

    mounted(){
        this.getAllPoint();
        this.$nextTick(function() {
			window.addEventListener('resize', this.handleResize);
			this.handleResize()
		})
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
    methods:{
        getPageview:function(){
            //this.active = true;                     
        }, 

        handleResize(event){

            this.card.width = this.$refs.card.$el.clientWidth;
            this.card.height = this.$refs.card.$el.clientHeight;
            //console.log(this.card);

            this.map.height = this.$refs.map.offsetHeight;
            this.map.width = this.$refs.map.offsetWidth;
        },
      
        //------------------Add the new point--------------------
        getAllPoint(){
            axios.get('/api/getSite').then(response => {            
                for(var i = 0; i < response.data.length; i++){
                    // var position = JSON.parse(response.data[i].position)[0];
                    // this.points.push(position);

                    let event = {
                        id:'',
                        name:'',
                        type:'',                
                        description:'',
                        open_hour:'',
                        location:'',
                        thumbnail:[],                
                        coordinate:[],
                        status:'',
                    };

                    var mythumbnail = JSON.parse(response.data[i].thumbnail);
                    var myposition = JSON.parse(response.data[i].coordinate);

                    event.id = response.data[i].id;
                    event.name = response.data[i].name;
                    event.type = response.data[i].type;
                    event.description = response.data[i].description;

                    if(response.data[i].open_hour == null){
                        var nowtime = new Date();
                        var time = nowtime.toISOString();
                        //console.log(time);

                        var newDate = nowtime.setHours(nowtime.getHours() + 1);
                        var nexthour = new Date(newDate);
                        nexthour = nexthour.toISOString()
                        //console.log(nexthour);
                        
                        var myopen_hour = [
                            time,
                            nexthour,
                            ];
                        myopen_hour = JSON.stringify(myopen_hour);
                        event.open_hour = myopen_hour;
                    }else{
                        event.open_hour = response.data[i].open_hour;
                    }

                    event.location = response.data[i].location;
                    event.thumbnail = mythumbnail;       
                    event.status = response.data[i].status;
                    event.coordinate = myposition;

                    this.points.push(event);
                }      
                
            }).catch(error => {
                console.log(error);             
            });
        },
        
        deletePoint(){
            this.$confirm('Do you want to delete this item?', 'Warning', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    axios.delete('/api/deleteSite', {
                        params: {
                            "id": this.facilities.id
                        }
                    }).then(res=>{                     
                        this.$vs.notify({color:'success',title:'Delete Success',text:'Your request is success.'});
                        this.points=[];
                        this.getAllPoint();
                    });
                    
                }).catch(res => {
                    this.$vs.notify({color:'primary',title:'Canceled',text:'Your request is canceled.'});
                    this.points=[];
                    this.getAllPoint();       
            });
        },

        //update onclick point id
        onClicked(id){        
            if(this.facilities.id != id){
                this.changeID = true;
                this.facilities.id = id;
            }else{
                this.changeID = false;
            }        
        },
        //update onclick point start position
        onDragging(newRect){         
            if(!this.startDrag){
                this.startDrag = true;
                this.top = newRect.top;
                this.left = newRect.left;
            }  
        },
        //check update position or delect point or on click 
        onDragstop(newRect){
            this.startDrag = false;
      
            var x = String("" + newRect.left);   
            var y = String("" + newRect.top);

            //drag to the black-hole
            if(newRect.top >= this.card.height - 90  && newRect.left >= this.card.width - 90){
                this.deletePoint();
            }
            //update position
            else if(this.top - newRect.top != 0 || this.left - newRect.left != 0)
            {
                axios.post('/api/updateSiteXY', {
                    "id": this.facilities.id,
                    "x": x,
                    "y": y,        
                }).then(res=>{
                    this.active = false;
                    this.$vs.notify({color:'success',title:'Update Success',text:res.data});
                });
            }
            //On Click the button
            else{      
                if(this.changeID){
                    let params = {"id": this.facilities.id};

                    axios.get('/api/getSiteById',{params}).then( response => {  
                        this.active = true;
                        
                        var mythumbnail = JSON.parse(response.data[0].thumbnail);
                        var myOpen_hour = JSON.parse(response.data[0].open_hour);
                        
                        console.log(myOpen_hour);


                        this.fileList = [];
                        this.fileList.push(mythumbnail);

                        this.facilities.name = response.data[0].name;
                        this.facilities.type = response.data[0].type;
                        this.facilities.description = response.data[0].description;
                        this.facilities.open_hour = myOpen_hour;
                        this.facilities.location = response.data[0].location;
                        this.facilities.thumbnail = mythumbnail;       
                        this.facilities.status = response.data[0].status;

                    }).catch(error => {
                        console.log(error);             
                    });
                }  
                else{
                    this.active = true;
                } 
            }

            
        },

        //--------------------Add point with Drag---------------------------
        addDrag(event){
        },
        drop:function(event){
            event.preventDefault();       
            
            //Set open hour 
            var nowtime = new Date();
            var time = nowtime.toISOString();

            var newDate = nowtime.setHours(nowtime.getHours() + 1);
            var nexthour = new Date(newDate);
            nexthour = nexthour.toISOString()
          
            var myopen_hour = [
                   time,
                   nexthour,
                ];
            myopen_hour = JSON.stringify(myopen_hour);

            //Set up position
            var pos_X = new String(""+event.layerX-16);
            var pos_Y = new String(""+event.layerY-32);
            var position = [{
                    x: pos_X,
                    y: pos_Y,
                }];

            //Add the point 
            axios.post('/api/addSite', {
                "name": 'New item',
                "type": 'toilet',
                "description": 'New item',
                "open_hour": myopen_hour,
                "location": 'New item',
                "thumbnail": '[]',
                "coordinate" : position,
                "status": 'Disabled',
            }).then(res=>{           
                this.$vs.notify({color:'success',title:'Upload Success',text:res.data});
                this.points=[];
                this.getAllPoint();
            }); 
        },
        allowDrop:function(event){
            event.preventDefault();     
        },

        //------------------Thunbmnail upload--------------------
        handleRemove(file, fileList) {
            //console.log(file, fileList);
            this.isChangedImage = true;
            this.fileList = fileList.slice();
        },       
        handleChange(file, fileList) {
            //console.log(fileList);
            this.isChangedImage = true;
            this.fileList = fileList.slice();
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },

        //------------------Submit Form---------------------------
        submitForm(formName) {
            //Upload image
            if(this.fileList.length == 0){
                this.facilities.thumbnail = [];
            }
            else if(this.isChangedImage == true){
                this.facilities.thumbnail = [];

                for(var i = 0; i < this.fileList.length; i++){    
                    if(this.fileList[i].hasOwnProperty('raw')){
                        var filename = this.fileList[i].uid + "_" + this.fileList[i].name;
                        var file_url = '/storage/sitemaps_images/' + filename;

                        const fd = new FormData();
                        fd.append('theFile', this.fileList[i].raw, filename);
                        axios.post('/uploadSiteMapImage.php',fd).then(res=>{
                            //console.log(res);               
                        });
                        
                        var allFile = {
                            name: filename,
                            url: file_url
                        };

                        this.facilities.thumbnail.push(allFile);

                    }else{
                        var filename = this.fileList[i].name;
                        var file_url = this.fileList[i].url; 
                        var allFile = {
                            name: filename,
                            url: file_url
                        };

                        this.facilities.thumbnail.push(allFile);
                    }      
                }
            }
                       
            //Update data
            this.$refs[formName].validate((valid) => {       

                //format open hour
                var start_time =  moment(this.facilities.open_hour[0]);
                var end_time = moment(this.facilities.open_hour[1]);
                var format_start = start_time.format("YYYY-MM-DD HH:mm:ss");
                var format_end = end_time.format("YYYY-MM-DD HH:mm:ss");
                this.facilities.open_hour[0] = format_start;
                this.facilities.open_hour[1] = format_end;
                var my_open_hour = JSON.stringify(this.facilities.open_hour);

                var mythumbnail = JSON.stringify(this.facilities.thumbnail);
    
                if (valid) {
                    axios.post('/api/updateSite', {
                        "id": this.facilities.id,
                        "name": this.facilities.name,
                        "type": this.facilities.type,
                        "description": this.facilities.description,
                        "open_hour": my_open_hour,
                        "location": this.facilities.location,
                        "thumbnail": mythumbnail,
                        "status": this.facilities.status
                    }).then(res=>{
                        this.active = false;
                        this.$vs.notify({color:'success',title:'Upload Success',text:res.data});
                        this.points=[];
                        this.getAllPoint();
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });

        },
        resetForm(formName) {
           
        },
    }
}
</script>

<style>
  @import url("//unpkg.com/element-ui@2.9.1/lib/theme-chalk/index.css");

    .header-sidebar{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
    }

    .header-sidebar h4{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    h4 button{
        margin-left: 10px;
    }
            
    .footer-sidebar{
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .footer-sidebar button{
        border: 0px solid rgba(0,0,0,0) !important;
        border-left: 1px solid rgba(0,0,0,.07) !important;
        border-radius: 0px !important;
    }

    .vs-sidebar--items{
        height: 100%;
    }

    .vs-sidebar{
        z-index: 300;
        max-width: 600px;
    }

    .vs-sidebar--background{
        z-index: 300;
    }

    .items-baseline{
        align-items: baseline;
    }

    .black-hole{
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
    
    .placeholder{
        position: absolute;
        bottom: 45px;
        left: 200px;
    }

    .vdr.active:before{
        outline: 0px dashed #d6d6d6; 
    }
    
    @font-face {
        font-family: 'Material Icons';
        font-style: normal;
        font-weight: 400;
        src: url(https://fonts.gstatic.com/s/materialicons/v47/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
    }

    .material-icons {
        font-family: 'Material Icons';
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: 'liga';
        -webkit-font-smoothing: antialiased;
    }
</style>
