#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#define MAX 10
struct input
{
	char label[10],opcode[10],operand[10],mnemonic[5];
   	int loc;
};
struct input table[MAX];
struct symtab
{
	char sym[10];
	int f,val,ref;
};
struct symtab symtb1[MAX];
void main()
{
            int f1,i=1,j=1,flag,locctr,x;
            char add[10],code[10],mnemcode[5];
            FILE *fp1,*fp2,*fp3;
            clrscr();
            printf("\nImplementation Of A Single Pass Assembler:");
            printf("\n------------------------------------------\n\n");
            fp1=fopen("input.txt","r");
            fp2=fopen("optab.txt","r");
            fp3=fopen("spout.txt","w");
            fscanf(fp1,"%s%s%s",table[i].label,table[i].opcode,table[i].operand);
            if(strcmp(table[i].opcode,"START")==0)
            {
 	             locctr=atoi(table[i].operand);
        	     i++;
              	     fscanf(fp1,"%s%s%s",table[i].label,table[i].opcode,table[i].operand);
            }
            else  locctr=0;
            while(strcmp(table[i].opcode,"END")!=0)
            {
            		if(strcmp(table[i].label,"**")!=0)
              		{
                for(x=1;x<j;x++)
                {
                  f1=0;
                  if((strcmp(symtb1[x].sym,table[i].label)==0) && (symtb1[x].f==1))
                  {
                        symtb1[x].val=locctr;
                        symtb1[x].f=0;
                        table[symtb1[x].ref].loc=locctr;
                        f1=1;  break;
                  }
                }
                if(f1==0)
                {
                  strcpy(symtb1[j].sym,table[i].label);
                  symtb1[j].val=locctr;
                  symtb1[j].f=0; j++;
                }
              }
              fscanf(fp2,"%s%s",code,mnemcode);
              while(strcmp(code,"END")!=0)
              {
                if(strcmp(table[i].opcode,code)==0)
                {
                  strcpy(table[i].mnemonic,mnemcode);
                  locctr+=3;
                  for(x=1;x<=j;x++)
                  {
                        flag=0;
                        if(strcmp(table[i].operand,symtb1[x].sym)==0)
                        {
                          flag=1;
                          if(symtb1[x].f==0)
                          table[i].loc=symtb1[x].val;
                          break;
                        }
                  }
                  if(flag!=1)
                  {
                        strcpy(symtb1[j].sym,table[i].operand);
                        symtb1[j].f=1;
                        symtb1[j].ref=i; j++;
                  }
                }
                fscanf(fp2,"%s%s",code,mnemcode);
              }
              rewind(fp2);
           
  if(strcmp(table[i].opcode,"WORD")==0)                                 
              {
                locctr+=3;
                strcpy(table[i].mnemonic,'\0');
                table[i].loc=atoi(table[i].operand);
              }
              else if(strcmp(table[i].opcode,"RESW")==0)
              {
                locctr+=(3*(atoi(table[i].operand)));
                strcpy(table[i].mnemonic,'\0');
                table[i].loc=atoi('\0');
              }
              else if(strcmp(table[i].opcode,"RESB")==0)
              {
                locctr+=(atoi(table[i].operand));
                strcpy(table[i].mnemonic,'\0');
                table[i].loc=atoi('\0');
              }
              else if(strcmp(table[i].opcode,"BYTE")==0)
              {
                ++locctr;
                if((table[i].operand[0]=='C') || (table[i].operand[0]=='X'))
                  table[i].loc=(int)table[i].operand[2];
                else
                  table[i].loc=locctr;
              }
              i++;
              fscanf(fp1,"%s%s%s",table[i].label,table[i].opcode,table[i].operand);
            }
            for(x=1;x<i;x++)
fprintf(fp3,"%s\t%s\t%s\t%s\n",table[x].label,table[x].opcode,table[x].operand,
strcat(table[x].mnemonic,itoa(table[x].loc,add,10)));
            for(x=1;x<j;x++)
              printf("%s\t%d\n",symtb1[x].sym,symtb1[x].val);
            printf("\nProgram Completed Successfully...\n");
            getch();
}

