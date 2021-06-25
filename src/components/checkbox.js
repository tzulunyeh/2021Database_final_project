import React,{Component} from 'react';
import axios from 'axios';
import '../style/checkbox.css';
import {Button} from '@material-ui/core'
import {Link} from 'react-router-dom'
import styled from 'styled-components';
class Testcheckbox extends Component {
    state ={
        Lee:"",
        Club : "50",
        Exc:"50",
        Med : "50",
        Shop:"50",
        Price:"20000",
        Ping:"200",
        Year:"100",
        Data: [],
        selectvill: [],
        Issearch: "",
    }
    
    handleLee = async e =>{
        await this.setState({
            Lee : e.target.value,
        })
    }
    handleClub = async e =>{
        await this.setState({
            Club : e.target.value, 
        })
    }
    handleExc = async e =>{
        await this.setState({
            Exc : e.target.value, 
        })
    }
    handleMed = async e =>{
      await this.setState({
          Med : e.target.value, 
      })
    }
    handleShop = async e =>{
      await this.setState({
          Shop : e.target.value, 
      })
    }
    handlePrice = async e =>{
      await this.setState({
          Price : e.target.value, 
      })
    }
    handlePing = async e =>{
      await this.setState({
          Ping : e.target.value, 
      })
    }
    handleYear = async e =>{
      await this.setState({
          Year : e.target.value, 
      })
    }
    
Selectaddress_vill = () => {
    let villOption = new FormData();
    villOption.append("city", "新北市");
    villOption.append("area", "林口區");
    const url = "http://35.174.176.147/final_pro/login/vill.php";
    axios.post(url,villOption)
        .then(res => {
            console.log(res)
            console.log(res.data)
            this.setState({ selectvill:res.data });
        })
        .catch(err => console.log(err));
}
handleSubmit = e =>{
        e.preventDefault();
        console.log(this.state.Lee)
        console.log(this.state.Club);
        console.log(this.state.Exc);
        console.log(this.state.Med);
        console.log(this.state.Shop);
        console.log(this.state.Price);
        console.log(this.state.Ping);
        console.log(this.state.Year);


        let formData = new FormData();
        formData.append("Vill",this.state.Lee);
        formData.append("Club",this.state.Club);
        formData.append("Exc",this.state.Exc);
        formData.append("Med",this.state.Med);
        formData.append("Shop",this.state.Shop);
        formData.append("Price",this.state.Price);
        formData.append("Ping",this.state.Ping);
        formData.append("Year",this.state.Year);
        const url = "http://35.174.176.147/final_pro/search.php";
        axios.post(url,formData)
        .then(res=>{
            console.log(res.data)
            this.setState({ Data:res.data });
            if(res.data.length===0){
                alert("找不到房子 請重新輸入條件")
                this.setState({Issearch:""})
            }
            else {
                this.setState({ Issearch: "did" })
                console.log(this.state.Issearch)
                alert("已為您找到房子")
            }
        })

        .catch(err=>console.log(err));

    }

    render() {
        return (
            <Content>
                <div className="page" style={{
                    display: "relative",
                    alignItems:"center",
                    marginBottom:"30vh",
                }}>
                <div className="select">
                    <select onChange={this.handleLee} onClick={this.Selectaddress_vill}>
                        <option>哪里</option>
                        {this.state.selectvill.map(post => (
                            <option>{post.里}</option>
                        ))}
                    </select>
    
                    <select onChange={this.handleClub}>
                        <option value="">Near Clubs</option>
                        <option value="0.5">Less then 0.5km</option>
                        <option value="1">Less then 1km</option>
                        <option value="2">Less then 2km</option>
                    </select>
                    
                    <select onChange={this.handleExc}>
                        <option value="">Near Exercise</option>
                        <option value="0.5">Less then 0.5km</option>
                        <option value="1">Less then 1km</option>
                        <option value="2">Less then 2km</option>
                    </select>
                    {/* <button onClick={this.handleSubmit}  id="submit">save</button> */}
                    
                    <select onChange={this.handleMed}>
                        <option value="">Near Medical</option>
                        <option value="0.5">Less then 0.5km</option>
                        <option value="1">Less then 1km</option>
                        <option value="2">Less then 2km</option>
                    </select>
                    
                    <select onChange={this.handleShop}>
                        <option value="">Near Shop</option>
                        <option value="0.5">Less then 0.5km</option>
                        <option value="1">Less then 1km</option>
                        <option value="2">Less then 2km</option>
                    </select>
                    
                    <select onChange={this.handlePrice}>
                        <option value="">Price Range</option>
                        <option value="1000">Under 10 million</option>
                        <option value="2000">Under 20 million</option>
                        <option value="3000">Under 30 million</option>
                        <option value="4000">Under 40 million</option>
                    </select>
                    
                    <select onChange={this.handlePing}>
                        <option value="">Ping</option>
                        <option value="50">Under 50 ping</option>
                        <option value="75">Under 75 ping</option>
                        <option value="100">Under 100 ping</option>
                    </select>
                    
                    <select onChange={this.handleYear}>
                        <option value="">House Age</option>
                        <option value="5">Under 5 years</option>
                        <option value="10">Under 10 years</option>
                        <option value="15">Under 15 years</option>
                        <option value="20">Under 20 years</option>
                    </select>
                    
                </div>

                <div className="SearchButton">
                        <Button variant="contained" onClick={this.handleSubmit}  id="submit" color="primary">
                            查房!
                        </Button>
                        {this.state.Issearch ? (
                            <Link
                            to ={{
                                pathname:'/result',
                                aboutProps:{
                                    result:this.state.Data,
                                }
                            }}
                            >

                                <Button variant="outlined" color="secondary">
                                    查看細節
                                </Button>
                            </Link>
                        ): (
                            <div></div>
                        )}
                        
                    </div>

                </div>
            </Content>
        )
    } 
}

const Content = styled.div`
    display: flex;
    align-items: center;
    justify-content: center;
    height:100vh;
    width:100vw;
    background-image: url("/images/checkboxbg.jpg");
    background-size: cover;
`;

export default Testcheckbox;