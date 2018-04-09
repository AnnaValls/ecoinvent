'''
  decode a technology mix description based on 7 bits packed into a string

  bit position | technology
  -------------+--------------------------
  0            | primary settler
  1            | bod removal
  2            | nitrification
  3            | denitrification
  4            | bio P removal
  5            | chem P removal
  6            | metals and other elements
  -------------+--------------------------
  example: "1110001"
  means:
    treatment with primary settler,
    with bod removal,
    with nitrification,
    without denitrification,
    without bio P removal,
    without chem P removal,
    with metals and other elements,
'''

def decode(bit_string): #i.e "1110001"
  print('Input: '+bit_string)
  tecs=[
    'Primary settler',
    'BOD removal',
    'Nitrification',
    'Denitrification',
    'Bio P removal',
    'Chem P removal',
    'Metals and other elements',
  ]
  rv=[] #return value that will be constructed below

  #check if length of bit string is too large
  if(len(bit_string)>len(tecs)):
    raise ValueError('bit string has more characters than existing wwt technologies')

  #loop bit_string characters
  for i in range(len(bit_string)):
    c=bit_string[i]
    if c=='1':
      rv.append(tecs[i])
    elif c=='0':
      pass
    else:
      raise ValueError('bit string had a character which is not 0 or 1:',c)

  #join array into a single string using ', ' as separator
  if(len(rv)):
    rv=', '.join(map(str,rv))
  else:
    rv='nothing'

  rv="Technology mix: "+rv+"."

  #return statement
  print(rv) #for debugging only
  return(rv)

'''TESTS'''
#decode('000') #does not fail because length < 7 but returns 'nothing'
#decode('111') #does not fail because length < 7
#decode('1110001') #does not fail because length == 7 (normal case)
#decode('abc') #should fail because at least one character is not '0' or '1'
#decode('1111111000111') #should fail because length > 7
#decode(3) #should fail because input type is not 'str'
