import React ,{useState,useEffect}from 'react';
import {useLocation} from 'react-router-dom'
import {Link} from 'react-router-dom'
import GoogleMapTest from './googlemap';
import styled from 'styled-components';
import axios from 'axios';
import Geocode from "react-geocode";


function Detail() {
   
    const location = useLocation();
    let info = []


   
    info=location.aboutProps.result

    const [houseid,sethouseid] = useState(info[0].houseid);//houseid
    const [name,setName] = useState(info[0].name);
    const [address,setaddress] = useState(info[0].address);
    const [price,setprice] = useState(info[0].price);
    const [ping,setping] = useState(info[0].坪);
    const [year,setyear] = useState(info[0].屋齡);
    const [bigRoom,setbigRoom] = useState(info[0].廳);
    const [smallRoom,setsmallRoom] = useState(info[0].房);
    const [project,setproject] = useState(info[0].建案);
    const [nowFloor,setnowFloor] = useState(info[0].樓層);
    const [parking,setparking] = useState(info[0].停車位);
    const [totalFloor,settotalFloor] = useState(info[0].總樓數);
    const [link,setlink] = useState(info[0].link);
    const [bathRoom,setbathRoom] = useState(info[0].衛);
    const [centerlat,setlat] = useState(info[0].緯);
    const [centerlng,setlong] = useState(info[0].經);


    var temp="";//get houseid by onClick
    var index=0;//get index of houseid


    const handleHouseId  = async (e) => {
        temp = await e.currentTarget.value;
        index = info.findIndex( s => s.houseid == temp );
        console.log(temp);
        console.log(index = info.findIndex( s => s.houseid == temp ));
        sethouseid(temp);
        setName(info[index].name);
        setaddress(info[index].address);
        setprice(info[index].price);
        setping(info[index].坪);
        setyear(info[index].屋齡);
        setbigRoom(info[index].廳);
        setproject(info[index].建案);
        setparking(info[index].停車位); 
        setnowFloor(info[index].樓層);
        settotalFloor(info[index].總樓數);
        setbathRoom(info[index].衛);
        setlink(info[index].link);
        setsmallRoom(info[index].房);
        setlat(info[index].緯);
        setlong(info[index].經);
        

       
        setresponseNear(info[index].address);
    };


    const [responseNear,setresponseNear]=useState('');



// ----------------------------store response shop data for map
    const handleShopInfo =async (e)=>{
        let formData = new FormData();
        formData.append("houseid",houseid);
        const url="http://35.174.176.147/final_pro/other/shop.php";
        //only post one time
            axios.post(url,formData)
                .then(res => {
                console.log('Shop')
                console.log(res.data)
                setresponseNear(res.data);
            })
            .catch(err=>console.log(err))
    }

// ----------------------------store response med data for map
    const handleMedInfo =async (e)=>{
        let formData = new FormData();
        formData.append("houseid",houseid);
        const url="http://35.174.176.147/final_pro/other/medical.php";
        //only post one time
            axios.post(url,formData)
            .then(res=>{
                console.log('Med')
                console.log(res.data)
                setresponseNear(res.data);
                
            })
            .catch(err=>console.log(err))
    }


// ----------------------------store response exercise data for map
    const handleExerciseInfo =async (e)=>{
        let formData = new FormData();
        formData.append("houseid",houseid);
        const url="http://35.174.176.147/final_pro/other/exercise.php";
        //only post one time
            axios.post(url,formData)
            .then(res=>{
                console.log('Ex')
                console.log(res.data)
                setresponseNear(res.data);
            })
            .catch(err=>console.log(err))
    }

// ----------------------------store response club data for map
    const handleClubInfo =async (e)=>{
        let formData = new FormData();
        formData.append("houseid",houseid);
        const url="http://35.174.176.147/final_pro/other/club.php";
        //only post one time
            axios.post(url,formData)
            .then(res=>{
                console.log('Club')
                console.log(res.data)
                setresponseNear(res.data);
            })
            .catch(err=>console.log(err))
    }


//method to get request

    return (
        <div className="detailContainer" style={{
            display: "flex",
            position:"relative",
            color:"black",
        }}>
            <div className="Content" style={{
                marginTop:"8vh",
                display: "flex",
                flexDirection:"row",
                width:"31vw",
            }}>
                <div className="list" style={{
                    overflow:"auto",
                    width: "auto",
                    height: "92vh",
                    
                }}>
                    <table border = "5" cellPadding = "10" cellSpacing = "5" style={{
                        overflowY: "auto",
                        textAlign:"left",
                        width: "30vw",
                    }}>
                        <thead>
                            <tr>
                            <th style={{position:"fixed",left:"21.9vw",}}>
                                <a href="/checkbox" style={{color:"black",fontSize:"15px"}}>
                                    Back to Search Box
                                </a>
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            { info.map((data) =>(
                                <tr>
                                    <button value={data.houseid} onClick={handleHouseId} style={{borderRadius:"0"}}>
                                        <th>{data.name}</th>
                                    </button>
                                </tr>
                            ))}

                        </tbody>
                    </table>
                </div>
            </div>
            <div className="Content2" style={{
                    marginTop: "8vh",
                    height: "92vh",
                    width: "69vw",
                    display: "flex",
                    flexDirection: "column",
                    justifyContent: "space-between",
            }}>
                <h1>{name}</h1>
                <p>地址:{address}</p>
                <p>價格:{price}萬</p>
                <p>建坪:{ping}坪</p>
                <p>屋齡:{year}年</p>
                <p>房:{smallRoom}&nbsp;廳:{bigRoom}&nbsp;衛:{bathRoom}</p>
                <p>建案:{project}</p>
                <p>所在樓層:{nowFloor}/總樓層:{totalFloor}</p>
                <p>停車位:{parking}</p>
                <p><a style={{color:"black",}} href={link} target="_blank">網址:{link}</a></p>
                <div className="mapbutt" style={{
                    display:"flex",
                    justifyContent:"flex-start",
                    flexWrap:"nowrap",
                    width:"200px",
                    height: "50px",
                    flexDirection:"row",
                    alignItems:"flex-end",
            }}>
                <Buttons>
                    <button value={houseid} onClick={handleShopInfo} >Shop </button>
                    <button value={houseid} onClick={handleMedInfo}>Med </button>
                    <button value={houseid} onClick={handleExerciseInfo}>Exc </button>
                    <button value={houseid} onClick={handleClubInfo}>Club </button>
                </Buttons>
            </div >
                <GoogleMapTest responseNear={responseNear} centerlat={centerlat} centerlng={centerlng} style={{
                    minWidth:"800px",
                    }}/>          
            </div>
            
        </div>
    )
}

const Buttons = styled.div`
    button{
        width:50px;
        height:40px;
        font-size: 1em;
    }
    
`;
export default  Detail