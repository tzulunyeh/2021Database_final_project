import React,{useState} from 'react';
import Geocode from "react-geocode";
import { GoogleMap,LoadScript,Marker} from '@react-google-maps/api';
export default function GoogleMapTest(props) {
    const { responseNear,centerlat,centerlng } = props;
    if (!Array.isArray(responseNear)) {
        console.log("it's not array")
    } 
    
    const [selectplace, setSelectedplace] = useState(" ")

    const handleClick = (user) => {
      const set = user === selectplace ? " " : user
      setSelectedplace(set)
    }
    
  

    Geocode.setApiKey("AIzaSyDCyp4PlSITFDqxhZpxEwjoQkGKxVPSNZk");

  const containerStyle = {
      width: '800px',
      height: '400px'
  };
  return (
    <div className="ggmap" style={{
        display:"flex",
        display: "flex",
        justifyContent: "flex-start",
        flexwrap: "nowrap",
        }}>
    <LoadScript
      googleMapsApiKey= "AIzaSyDCyp4PlSITFDqxhZpxEwjoQkGKxVPSNZk"
    >
      <GoogleMap
        mapContainerStyle={containerStyle}
        zoom={15}
        center={{lat:centerlat,lng:centerlng}}
      >
        <div>
        <Marker  position={{lat:centerlat,lng:centerlng}} icon='/placeholder.png' />
            {Array.isArray(responseNear) ? (
                responseNear.map((info) => (
                <Marker
                  position={{
                    lat:info.緯,
                    lng:info.經
                  }}
                  onClick={() => {
                    handleClick(info)
                    console.log(info)
                  }}
                />
                ))      
            ): (
                console.log('no data')            
            )}
        </div>
        
      </GoogleMap>
      
    </LoadScript>
        <div className="infowindow" style={{display:"block", width:"550px", marginLeft:"10px",}}>
            {selectplace.name ?(<h4>名稱:{selectplace.name}</h4>):(null)}
            {selectplace.address ?(<p>地址:{selectplace.address}</p>):(null)}
            {selectplace.tel ?(<p>電話:{selectplace.tel}</p>):(null)}
            {selectplace.level ?(<p>醫療等級:{selectplace.level}</p>):(null)}
            {selectplace.type ?(<p>科別:{selectplace.type}</p>):(null)}
            {selectplace.活動 ?(<p>活動:{selectplace.活動}</p>):(null)}
            {selectplace.設施 ?(<p>設施:{selectplace.設施}</p>):(null)}
            {selectplace.shopnum ?(<p>攤位數:{selectplace.shopnum}</p>):(null)}
            {selectplace.time ?(<p>營業時間:{selectplace.time}</p>):(null)}
      </div>
    </div>
  )
}