using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO.Ports;
using System.IO;
using MySql.Data.MySqlClient;
using System.Net;
using System.Threading;

namespace SerialTest
{
    public partial class Form1 : Form
    {
        SerialPort serialPort;
        string strUri = "http://210.94.194.64:8080/arduino/save_data.php?";
        string bed_data = "";
      
       
        int t;
        Thread th = null;
        
        public Form1()
        {
            InitializeComponent();

            textBox1.SelectionStart = textBox1.Text.Length;
            textBox1.ScrollToCaret();


          
        }
        private void Form1_Load(object sender, EventArgs e)
        {
            /*시리얼 포트 번호*/
            comboBox1.Items.Add("1");
            comboBox1.Items.Add("2");
            comboBox1.Items.Add("3");
            comboBox1.Items.Add("4");
            comboBox1.Items.Add("5");
            comboBox1.Items.Add("6");
            comboBox1.Items.Add("7");
            comboBox1.Items.Add("8");
            comboBox1.Items.Add("9");
            comboBox1.Items.Add("10");
        }


        void serialPort_DataReceived()
        {
            while (true)
            {
                serialPort.Open();
                string text_data = "";
                for (int i = 0; i < 2; i++)
                {
                    int iRecSize = serialPort.BytesToRead;//수신된 데이터갯수

                    System.Threading.Thread.Sleep(1000);
                    if (i == 0)//첫번째는 패스
                        continue;
                   

                    if (iRecSize > 0)
                    {
                        string strRecData;

                        strRecData = "";

                        while(true)
                        {
                            strRecData = "";

                            /*parsing*/
                            strRecData = "sensor_id = bed1 |" + serialPort.ReadLine();
                            
                            textBox1.AppendText(strRecData + "\n");
                            strRecData = strRecData.Replace(" ", "");
                            char[] del = { '\r' };
                            string[] sp = strRecData.Split(del);
                            text_data = strRecData + "\n";
                            bed_data = sp[0].Replace("|", "&");

                            if(bed_data.Contains("AcX")&&bed_data.Contains("AcY")&& bed_data.Contains("AcZ")&&bed_data.Contains("Tmp")&& bed_data.Contains("GyX") && bed_data.Contains("GyY") && bed_data.Contains("GyZ"))
                            {/*send to DB*/
                                HttpWebRequest request = (HttpWebRequest)WebRequest.Create(strUri + bed_data);
                                request.Method = "GET";
                                HttpWebResponse response = (HttpWebResponse)request.GetResponse();
                                response.Close();
                                break;
                            } 
                         

                        }

                    }
                    System.Threading.Thread.Sleep(t-2000);
                }
                serialPort.Close();
                //MessageBox.Show("끝!");

                
            }
        }
        
        private void button1_Click(object sender, EventArgs e)
        {//데이터수신
           
            th = new Thread(new ThreadStart(serialPort_DataReceived));

            if (comboBox1.Text.Equals("")||textBox2.Text.Equals(""))//초나 포트가 비어있으면 실행 안함
            {
                MessageBox.Show("포트번호나 시간이 비어있습니다ㅏ");
            }
            else
            {
                
               

                    t = Int32.Parse(textBox2.Text) * 1000;
                if (t < 2000)
                {
                    MessageBox.Show("2초이상으로 적어주세요!");
                }
                else
                {
                    button1.Enabled = false; // 버튼 비활성화(두번못누름^ㅇ^)
                    th.Start();
                }
             
            } 
               
                
        }
       
        private void textBox1_TextChanged(object sender, EventArgs e)
        {
           
        }

        private void button2_Click(object sender, EventArgs e)
        {
            string COM;
            COM = comboBox1.Text;
            if (COM.Equals(""))
            {
                MessageBox.Show("포트번호를 정해주세용");
            }
            else
            {
                serialPort = new SerialPort("COM" + COM, 9600, Parity.None, 8, StopBits.One);
                serialPort.Open();
                MessageBox.Show("connect success!!");
                serialPort.Close();

            }
        }

        private void button3_Click(object sender, EventArgs e)
        {//중지
            th.Abort();
            comboBox1.Text = "";
            th = null;
        }

        private void label2_Click(object sender, EventArgs e)
        {

        }

      
        private void button5_Click(object sender, EventArgs e)
        {//재시작
            
        }
    }
}
