'####### EZE-CRYPT (VB6) ######
'#    Biznatch Enterprises    #
'#     www.biznaturally.ca    #
'##############################

'VB6 Source code rewritten from: https://github.com/JustinPercy/EZ-CRYPT

Dim KEYVALS(2) As Long

Function GENRANDOMCHAR(LOWLIMIT As Integer, HIGHLIMIT As Integer)
    Randomize Timer
    fa = Int(Rnd * 20 + 10)
    fb = Int(Rnd * 20 + 10)
    fc = Int(Rnd * 20 + 10)
    fd = Int(Rnd * 20 + 10)
    ff = fa + fb + fc + fd
    rstr = Chr(ff)
    If ff > HIGHLIMIT Then ff = ff - Int(Rnd * 5)
    If ff < LOWLIMIT Then ff = ff + Int(Rnd * 20)
    If ff > HIGHLIMIT Then ff = ff - Int(Rnd * 20)
    If ff < LOWLIMIT Then ff = ff + Int(Rnd * 5)
    If ff < LOWLIMIT Then ff = LOWLIMIT
    If ff > HIGHLIMIT Then ff = HIGHLIMIT
    ff = Int(ff)
    GENRANDOMCHAR = Chr(ff)
End Function

Function encryption(TEXTT As String, CRYPTKEY As String) As String
On Error GoTo handler

    If TEXTT = "" Then
        encryption = "NULLTEXT"
        Exit Function
    End If
    
    If CRYPTKEY = "" Then
        encryption = "NULLCRYPTKEY"
    Exit Function
    End If
    
    DoEvents
    
    Call genkeyvals(CRYPTKEY)

    estr = ""
    enc = ""

        For i = 1 To Len(TEXTT)

            DoEvents
            e = Asc(Mid(TEXTT, i, 1))
            e = e + KEYVALS(1)
            e = e * KEYVALS(2)
            rstr = GENRANDOMCHAR(65, 90)
            estr = estr & rstr & e
                                
        Next
        
    encryption = estr

    Exit Function
    
handler:

encryption = "ERROR"
End Function

Function genkeyvals(CRYPTKEY As String)
KEYVALS(1) = 0
KEYVALS(2) = 0

For i = 2 To Len(CRYPTKEY)
    DoEvents
    KEYVALS(1) = KEYVALS(1) + Asc(Mid(CRYPTKEY, i, 1))
    KEYVALS(2) = Len(CRYPTKEY)
Next

End Function

Function decryption(TEXTT As String, CRYPTKEY As String) As String
Dim g As Integer
On Error GoTo hand
    
Call genkeyvals(CRYPTKEY)
    tmp = 0
    estr = ""
    estrr = ""
   
    For i = 1 To Len(TEXTT)
    DoEvents

    aa = Mid(TEXTT, i, 1)
    ab = IsNumeric(aa)

        If ab = False Then
            If estr <> "" Then
            estr = estr / KEYVALS(2)
            estr = estr - KEYVALS(1)
            estrr = estrr & Chr(estr)
            estr = ""
            End If
        Else
        estr = estr & aa
        End If
        
    Next

ff = estr
ff = ff / KEYVALS(2)
ff = ff - KEYVALS(1)
estrr = estrr & Chr(ff)
decryption = estrr
Exit Function
    
hand:
decryption = "ERROR"
End Function


