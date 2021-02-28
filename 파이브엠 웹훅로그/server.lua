local DISCORD_WEBHOOK = "웹훅 url"
local DISCORD_NAME = "로그"
local STEAM_KEY = "" --입력 X, 사용법 모름
local DISCORD_IMAGE = "웹훅 프로필 이미지 링크"

PerformHttpRequest('webhookstarts', function() 
	local connect = {
			{
				["color"] = "255",
				["title"] = "웹훅 실행로그",
				["description"] = "웹훅 로그가 실행되었습니다.",
			}
		}
		PerformHttpRequest(DISCORD_WEBHOOK, function(err, text, headers) end, 'POST', json.encode({username = "웹훅 실행 로그", avatar_url = DISCORD_IMAGE, tts = false, embeds = connect}), { ['Content-Type'] = 'application/json' })
	
end)

AddEventHandler('chatMessage', function(source, name, message) 

	if string.match(message, "@everyone") then
		message = message:gsub("@everyone", "`@everyone`")
	end
	if string.match(message, "@here") then
		message = message:gsub("@here", "`@here`")
	end
	if STEAM_KEY == '' or STEAM_KEY == nil then
		local connect = {
			{
				["color"] = "255",
				["title"] = "채팅기록",
				["description"] = "닉네임: " .. name .. "\r채팅기록: \r" .. message .. "",
			}
		}
		PerformHttpRequest(DISCORD_WEBHOOK, function(err, text, headers) end, 'POST', json.encode({username = "채팅로그", avatar_url = DISCORD_IMAGE, tts = false, embeds = connect}), { ['Content-Type'] = 'application/json' })
	else
		PerformHttpRequest('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' .. STEAM_KEY .. '&steamids=' .. tonumber(GetIDFromSource('steam', source), 16), function(err, text, headers)
			local image = string.match(text, '"avatarfull":"(.-)","')
			sendToDiscord(DISCORD_WEBHOOK, function(err, text, headers) end, 'POST', json.encode({username = "채팅로그", avatar_url = DISCORD_IMAGE, tts = false, embeds = connect}), { ['Content-Type'] = 'application/json' })
		end)
	end
end)

AddEventHandler('playerConnecting', function() 
    --PerformHttpRequest(DISCORD_WEBHOOK, function(err, text, headers) end, 'POST', json.encode({username = DISCORD_NAME, content = "```CSS\n".. GetPlayerName(source) .. " connecting\n```", avatar_url = DISCORD_IMAGE}), { ['Content-Type'] = 'application/json' })
    sendToDiscord("서버를 입장했습니다.", "**" .. GetPlayerName(source) .. " 님이 ** 서버에 입장 하셨습니다.", 65280)
end)

AddEventHandler('playerDropped', function(reason) 
	local color = 16711680
	if string.match(reason, "킥") or string.match(reason, "밴") then
		color = 16007897
	end
  sendToDiscord("서버를 퇴장했습니다.", "**" .. GetPlayerName(source) .. "님이 ** 서버에서 퇴장 하셨습니다.. \n 사유: " .. reason, color)
end)

function GetIDFromSource(Type, ID)
    local IDs = GetPlayerIdentifiers(ID)
    for k, CurrentID in pairs(IDs) do
        local ID = stringsplit(CurrentID, ':')
        if (ID[1]:lower() == string.lower(Type)) then
            return ID[2]:lower()
        end
    end
    return nil
end

function stringsplit(input, seperator)
	if seperator == nil then
		seperator = '%s'
	end
	
	local t={} ; i=1
	
	for str in string.gmatch(input, '([^'..seperator..']+)') do
		t[i] = str
		i = i + 1
	end
	
	return t
end

function sendToDiscord(name, message, color)
  local connect = {
        {
            ["color"] = color,
            ["title"] = "**".. name .."**",
            ["description"] = message,
        }
    }
  PerformHttpRequest(DISCORD_WEBHOOK, function(err, text, headers) end, 'POST', json.encode({username = DISCORD_NAME, embeds = connect, avatar_url = DISCORD_IMAGE}), { ['Content-Type'] = 'application/json' })
end