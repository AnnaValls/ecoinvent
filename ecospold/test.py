import random
import sys

#hello
print("This is a dummy <a href='test.py'>python script</a> output executed on the server\n")

#compute a random number
print("Random number {0, 10000}:",int(10000*random.random()),'\n')

#print argument list
print("Argument list:")
i=0;
for arg in sys.argv:
  print("-",i,arg)
  i+=1;
