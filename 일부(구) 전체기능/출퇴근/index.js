const Discord = require('discord.js');
const fs = require("fs");
const config = require('./config.json');
const client = new Discord.Client();

client.on('ready', () => {
	(async function () {
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms))
        };
        console.log(client.user.tag)
		console.log(client.user.id)
		console.log('\n봇이 준비 되었습니다.');
    answered1 = true;
    answered2 = true;
    answered3 = true;
    userAnswer1 = "";
    userAnswer2 = "";
    userAnswer3 = "";
        var i = 0;
        while (i < 10) {
            client.user.setPresence({
                activity: {
                    name: '상메1'
                },
                status: 'online'
            })
            await sleep(2000)
			client.user.setPresence({
                activity: {
                    name: '상메2'
                },
                status: 'online'
            })
            await sleep(2000)
        }
    })();
});

client.on('message', async (message) => { 
    if (message.author.bot) return;
	
	if (message.content.startsWith('!출근')) {
       var d = new Date();
       var currentData = d.getFullYear() + "년 " + (d.getMonth() + 1) + "월 " + d.getDate() + "일 ";
       var currentTime = d.getHours() + "시 " + d.getMinutes() + "분 ";
       var time1_embed = new (require('discord.js').MessageEmbed)()
       time1_embed.setTitle('출근하였습니다.')
	   time1_embed.addField('** **', "**```출근한 유저: " + `${message.author.tag}` + "```**")
       time1_embed.addField('** **', "**```출근 시간: " + `${currentData + currentTime}` + "```**")
       time1_embed.setColor("RANDOM")
       message.channel.send(time1_embed)
    }
	
	if (message.content.startsWith('!퇴근')) {
       var d = new Date();
       var currentData = d.getFullYear() + "년 " + (d.getMonth() + 1) + "월 " + d.getDate() + "일 ";
       var currentTime = d.getHours() + "시 " + d.getMinutes() + "분 ";
       var time2_embed = new (require('discord.js').MessageEmbed)()
       time2_embed.setTitle('퇴근하였습니다.')
	   time2_embed.addField('** **', "**```퇴근한 유저: " + `${message.author.tag}` + "```**")
       time2_embed.addField('** **', "**```퇴근 시간: " + `${currentData + currentTime}` + "```**")
       time2_embed.setColor("RANDOM")
       message.channel.send(time2_embed)
    }
});

client.login(config.token);